<?php
namespace tratabor\components\systems;

use tratabor\interfaces\systems\IContext;

class Context implements IContext
{
    public function __construct($data)
    {

    }

    public function pushItemByName($itemName, $itemValue)
    {
        $item = new Item($itemName, $itemValue);

        return $this->createItem($item, static::MODE__READ_WRITE);
    }
}
