<?php
namespace futuretek\geojson;

use futuretek\geojson\types\TypeInterface;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Json;

class GeoJson
{
    /**
     * @var array
     */
    public static $allowedTypes = ['Point', 'MultiPoint', 'LineString', 'MultiLineString', 'Polygon', 'MultiPolygon', 'GeometryCollection', 'Feature', 'FeatureCollection'];
    /**
     * @var array
     */
    public static $geometryObjects = ['Point', 'MultiPoint', 'LineString', 'MultiLineString', 'Polygon', 'MultiPolygon', 'GeometryCollection'];

    /**
     * @var TypeInterface[]
     */
    private $_items = [];

    /**
     * Add object to GeoJSON
     *
     * @param TypeInterface $object
     * @return self
     * @throws \yii\base\InvalidParamException
     */
    public function add(TypeInterface $object)
    {
        $this->_validate($object);
        $this->_items[] = $object;

        return $this;
    }

    /**
     * Output encoded GeoJSON
     *
     * @return string
     * @throws \yii\base\InvalidParamException
     */
    public function output()
    {
        $result = [];
        foreach ($this->_items as $object) {
            $result[] = $object->export();
        }

        return Json::encode($result);
    }

    /**
     * Check if object is valid
     *
     * @param TypeInterface $object
     * @throws \yii\base\InvalidParamException
     */
    private function _validate(TypeInterface $object)
    {
        if (!in_array($object->getType(), self::$allowedTypes, true)) {
            throw new InvalidParamException('Only types ' . implode(', ', self::$allowedTypes) . ' are allowed.');
        }
    }
}
