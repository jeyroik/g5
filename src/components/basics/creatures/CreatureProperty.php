<?php
namespace tratabor\components\basics\creatures;

use tratabor\interfaces\basics\creatures\ICreatureProperty;

/**
 * Class CreatureProperty
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureProperty implements ICreatureProperty
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * CreatureProperty constructor.
     * @param $propertyConfig
     */
    public function __construct($propertyConfig = [])
    {
        $this->initProperty($propertyConfig);
    }

    /**
     * @param $propertyConfig
     *
     * @return $this
     */
    protected function initProperty($propertyConfig)
    {
        $this->data = $propertyConfig;

        return $this;
    }
}
