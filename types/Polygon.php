<?php
namespace futuretek\geojson\types;

use yii\base\InvalidParamException;

/**
 * Class Polygon
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class Polygon implements TypeInterface
{
    /**
     * @var LineString[]
     */
    private $_lineStrings;

    /**
     * Polygon constructor.
     *
     * @param LineString[] $lineStrings
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(array $lineStrings)
    {
        if (0 === count($lineStrings)) {
            throw new InvalidParamException('Input array is empty.');
        }
        foreach ($lineStrings as $lineString) {
            if (count($lineString) < 4) {
                throw new InvalidParamException('LineString for use in polygon must be an array of four or more coordinates.');
            }
            if (!$this->_isClosed($lineString)) {
                throw new InvalidParamException('The first and last coordinates of the LineString must be equivalent.');
            }
        }

        //Polygon with holes
        if (1 < count($lineStrings)) {
            for ($i = 1, $iMax = count($lineStrings); $i < $iMax; $i++) {
                if (!$this->_isInside($lineStrings[$i], $lineStrings[0])) {
                    throw new InvalidParamException('For Polygons with multiple LineStrings, the first must be the exterior ring and any others must be interior rings or holes.');
                }
            }
        }

        $this->_lineStrings = $lineStrings;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'Polygon';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $result = [];
        foreach ($this->_lineStrings as $lineString) {
            $result[] = $lineString->export();
        }

        return ['type' => $this->getType(), 'coordinates' => $result];
    }

    /**
     * Check if LineString is closed
     *
     * @param LineString $lineString
     * @return bool
     */
    private function _isClosed(LineString $lineString)
    {
        $coordinates = $lineString->export();
        $c0 = $coordinates[0];
        $cn = end($coordinates);

        return $c0[0] === $cn[0] && $c0[1] === $cn[1];
    }

    /**
     * Calculates whether the specified inner LineString is inside the outer LineString
     *
     * @param LineString $inner
     * @param LineString $outer
     * @return bool
     */
    private function _isInside(LineString $inner, LineString $outer)
    {
        $aOuter = $outer->export();
        if (0 === count($aOuter)) {
            return false;
        }
        foreach ($inner->export() as $point) {
            $c = false;
            for ($i = 0, $count = count($aOuter), $j = $count - 1; $i < $count; $j = $i++) {
                $iteration = (
                        ($aOuter[$i][1] > $point[1]) !== ($aOuter[$j][1] > $point[1])
                    ) && (
                        $point[0] < ($aOuter[$j][0] - $aOuter[$i][0]) * ($point[1] - $aOuter[$i][1]) / ($aOuter[$j][1] - $aOuter[$i][1]) + $aOuter[$i][0]
                    );
                if ($iteration) {
                    $c = !$c;
                }
            }

            if (!$c) {
                return false;
            }
        }

        return true;
    }
}
