<?php
namespace futuretek\geojson\types;

use futuretek\geojson\GeoJson;
use yii\base\InvalidParamException;

/**
 * Class GeometryCollection
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class GeometryCollection implements TypeInterface
{
    /**
     * @var array
     */
    private $_geometries;

    /**
     * GeometryCollection constructor.
     *
     * @param Coordinates[] $objects
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(array $objects)
    {
        if (0 === count($objects)) {
            throw new InvalidParamException('Input array is empty.');
        }
        foreach ($objects as $obj) {
            $className = get_class($obj);
            if (!in_array($className, GeoJson::$geometryObjects, true)) {
                throw new InvalidParamException('Only types ' . implode(', ', GeoJson::$geometryObjects) . ' are allowed.');
            }
        }
        $this->_geometries = $objects;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'GeometryCollection';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $result = [];
        foreach ($this->_geometries as $coordinate) {
            $result[] = $coordinate->export();
        }

        return ['type' => $this->getType(), 'geometries' => $result];
    }
}
