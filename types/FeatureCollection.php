<?php
namespace futuretek\geojson\types;

use yii\base\InvalidParamException;

/**
 * Class FeatureCollection
 *
 * @package futuretek\geojson\types
 * @author  Lukas Cerny <lukas.cerny@futuretek.cz>
 * @license http://www.futuretek.cz/license FTSLv1
 * @link    http://www.futuretek.cz
 */
class FeatureCollection implements TypeInterface
{
    /**
     * @var Feature[]
     */
    private $_features;
    /**
     * @var BBox|null
     */
    private $_bBox;

    /**
     * FeatureCollection constructor.
     *
     * @param Feature[] $features
     * @param BBox|null $bBox
     * @throws \yii\base\InvalidParamException
     */
    public function __construct(array $features, $bBox = null)
    {
        foreach ($features as $feature) {
            if (!$feature instanceof Feature) {
                throw new InvalidParamException('Only Feature type is allowed.');
            }
        }
        $this->_features = $features;
        $this->_bBox = $bBox;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return 'FeatureCollection';
    }

    /**
     * @inheritdoc
     */
    public function export()
    {
        $result = [];
        foreach ($this->_features as $feature) {
            $result[] = $feature->export();
        }
        $arr = ['type' => $this->getType(), 'features' => $result];
        if ($this->_bBox instanceof BBox) {
            $arr['bbox'] = $this->_bBox->export();
        }

        return $arr;
    }
}
