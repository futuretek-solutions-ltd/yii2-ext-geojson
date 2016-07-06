<?php

namespace futuretek\geojson\types;

/**
 * Class Coordinates
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class Coordinates implements TypeInterface
{
    /**
     * @var float
     */
    private $_lat;
    /**
     * @var float
     */
    private $_lon;

    /**
     * Coordinates constructor.
     *
     * @param float $lat GPS Latitude
     * @param float $lon GPS Longitude
     */
    public function __construct($lat, $lon)
    {
        $this->_lat = (float)$lat;
        $this->_lon = (float)$lon;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'Coordinates';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        return [$this->_lon, $this->_lat];
    }
}