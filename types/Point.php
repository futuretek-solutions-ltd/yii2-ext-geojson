<?php
namespace futuretek\geojson\types;

/**
 * Class Point
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class Point implements TypeInterface
{
    /**
     * @var Coordinates
     */
    private $_coordinates;

    /**
     * Point constructor.
     *
     * @param Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        $this->_coordinates = $coordinates;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'Point';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        return ['type' => $this->getType(), 'coordinates' => $this->_coordinates->export()];
    }
}
