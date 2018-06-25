<?php
namespace tratabor\components\basics;

use jeyroik\extas\components\systems\Item;

/**
 * Class Basic
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class Basic extends Item
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * Basic constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->initConfig($config);
        parent::__construct($this->key, $this->value);
    }

    /**
     * @return mixed|string
     */
    public function getId()
    {
        return $this->data['id'] ?: parent::getId();
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return $this->data;
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function initConfig($config)
    {
        $this->data = $config;

        return $this;
    }
}
