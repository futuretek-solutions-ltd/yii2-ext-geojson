<?php
namespace futuretek\geojson\types;
use yii\base\InvalidParamException;

/**
 * Class MultiPoint
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class MultiPoint implements TypeInterface
{
    /**
     * @var Coordinates[]
     */
    private $_coordinates;

    /**
     * MultiPoint constructor.
     *
     * @param Coordinates[] $coordinates
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(array $coordinates)
    {
        if (0 === count($coordinates)) {
            throw new InvalidParamException('Input array is empty.');
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
        return 'MultiPoint';
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
