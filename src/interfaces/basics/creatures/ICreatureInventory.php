<?php
namespace tratabor\interfaces\basics\creatures;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IInventory
 * 
 * @stage.expand.type ICreatureInventory
 * @stage.expand.name tratabor\interfaces\basics\creatures\ICreatureInventory
 *
 * @stage.name creature.inventory.init
 * @stage.description Creature inventory initialization finish
 * @stage.input ICreatureInventory $creatureInventory
 * @stage.output void
 *
 * @stage.name creature.inventory.after
 * @stage.description Creature inventory destructing
 * @stage.input ICreatureInventory $creatureInventory
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureInventory extends IItem
{
    const SUBJECT = 'creature.inventory';
}
