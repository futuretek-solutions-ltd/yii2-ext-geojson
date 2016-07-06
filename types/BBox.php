<?php

namespace futuretek\geojson\types;

/**
 * Class BBox
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class BBox implements TypeInterface
{
    /**
     * @var float
     */
    private $_minLat;
    /**
     * @var float
     */
    private $_minLon;
    /**
     * @var float
     */
    private $_maxLat;
    /**
     * @var float
     */
    private $_maxLon;

    /**
     * BBox constructor.
     *
     * @param float $minLat Minimal GPS Latitude value
     * @param float $minLon Minimal GPS Longitude value
     * @param float $maxLat Maximal GPS Latitude value
     * @param float $maxLon Maximal GPS Longitude value
     */
    public function __construct($minLat, $minLon, $maxLat, $maxLon)
    {
        $this->_minLat = (float)$minLat;
        $this->_minLon = (float)$minLon;
        $this->_maxLat = (float)$maxLat;
        $this->_maxLon = (float)$maxLon;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'BBox';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        return [$this->_minLon, $this->_minLat, $this->_maxLon, $this->_maxLat];
    }
}