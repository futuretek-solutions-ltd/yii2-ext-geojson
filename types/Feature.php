<?php
namespace futuretek\geojson\types;

use futuretek\geojson\GeoJson;
use yii\base\InvalidParamException;

/**
 * Class Feature
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class Feature implements TypeInterface
{
    /**
     * @var TypeInterface
     */
    private $_geometry;
    /**
     * @var array|null
     */
    public $properties;
    /**
     * @var BBox|null
     */
    public $bBox;

    /**
     * Feature constructor.
     *
     * @param TypeInterface $object
     * @param array|null $properties
     * @param BBox|null $bBox
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(TypeInterface $object, $properties = null, $bBox = null)
    {
        if (!in_array($object->getType(), GeoJson::$geometryObjects, true)) {
            throw new InvalidParamException('Only types ' . implode(', ', GeoJson::$geometryObjects) . ' are allowed.');
        }
        $this->_geometry = $object;
        $this->properties = $properties;
        $this->bBox = $bBox;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'Feature';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $arr = ['type' => $this->getType(), 'geometry' => $this->_geometry->export(), 'properties' => $this->properties];
        if ($this->bBox instanceof BBox) {
            $arr['bbox'] = $this->bBox->export();
        }

        return $arr;
    }
}
