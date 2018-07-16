<?php
namespace tratabor\components\basics\creatures;

use jeyroik\extas\components\systems\Item;
use tratabor\interfaces\basics\creatures\ICreatureInventory;

/**
 * Class CreatureInventory
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureInventory extends Item implements ICreatureInventory
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return ICreatureInventory::SUBJECT;
    }
}
