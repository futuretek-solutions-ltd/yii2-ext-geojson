<?php

namespace futuretek\geojson\types;

/**
 * Interface TypeInterface
 *
 * @package futuretek\geojson\types
 */
interface TypeInterface
{
    /**
     * Get object type
     *
     * @return string
     */
    public function getType();

    /**
     * Export class properties to GeoJSON
     *
     * @return array
     */
    public function export();
}