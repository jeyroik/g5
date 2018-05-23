<?php
namespace tratabor\components\basics;

/**
 * Class BasicObject
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicObject extends Basic
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return $this->data;
    }
}
