<?php
namespace futuretek\geojson\types;

use yii\base\InvalidParamException;

/**
 * Class MultiPolygon
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class MultiPolygon implements TypeInterface
{
    /**
     * @var Polygon[]
     */
    private $_polygons;

    /**
     * MultiPolygon constructor.
     *
     * @param Polygon[] $polygons
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(array $polygons)
    {
        if (0 === count($polygons)) {
            throw new InvalidParamException('Input array is empty.');
        }
        foreach ($polygons as $polygon) {
            if (!$polygon instanceof Polygon) {
                throw new InvalidParamException('Only Polygon type is accepted.');
            }
        }

        $this->_polygons = $polygons;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'MultiPolygon';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $result = [];
        foreach ($this->_polygons as $polygon) {
            $result[] = $polygon->export();
        }

        return ['type' => $this->getType(), 'coordinates' => $result];
    }
}
