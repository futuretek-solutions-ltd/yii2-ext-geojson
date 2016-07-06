<?php
namespace futuretek\geojson\types;

use yii\base\InvalidParamException;

/**
 * Class MultiLineString
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class MultiLineString implements TypeInterface
{
    /**
     * @var LineString[]
     */
    private $lineStrings;

    /**
     * MultiLineString constructor.
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
            if (!$lineString instanceof LineString) {
                throw new InvalidParamException('Only LineString type is accepted.');
            }
        }
        $this->lineStrings = $lineStrings;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'MultiLineString';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $result = [];
        foreach ($this->lineStrings as $lineString) {
            $result[] = $lineString->export();
        }

        return ['type' => $this->getType(), 'coordinates' => $result];
    }
}
