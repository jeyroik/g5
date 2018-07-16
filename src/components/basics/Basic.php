<?php
namespace tratabor\components\basics;

use jeyroik\extas\components\systems\Item;

/**
 * Class Basic
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
abstract class Basic extends Item
{
    /**
     * @return mixed|string
     */
    public function getId()
    {
        return $this->config['id'] ?: '';
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return $this->config;
    }
}
