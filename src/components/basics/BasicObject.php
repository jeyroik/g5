<?php
namespace tratabor\components\basics;

/**
 * Class BasicObject
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicObject
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * BasicObject constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->initConfig($config);
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
