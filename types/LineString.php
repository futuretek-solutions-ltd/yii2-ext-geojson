<?php
namespace futuretek\geojson\types;

use yii\base\InvalidParamException;

/**
 * Class LineString
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class LineString implements TypeInterface
{
    /**
     * @var Coordinates[]
     */
    private $_coordinates;

    /**
     * LineString constructor.
     *
     * @param Coordinates[] $coordinates
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(array $coordinates)
    {
        if (count($coordinates) < 2) {
            throw new InvalidParamException('LineString must be an array of two or more coordinates.');
        }
        foreach ($coordinates as $coordinate) {
            if (!$coordinate instanceof Coordinates) {
                throw new InvalidParamException('Only Coordinates type is accepted.');
            }
        }
        $this->_coordinates = $coordinates;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'LineString';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $result = [];
        foreach ($this->_coordinates as $coordinate) {
            $result[] = $coordinate->export();
        }

        return ['type' => $this->getType(), 'coordinates' => $result];
    }
}
