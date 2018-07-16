<?php
namespace tratabor\interfaces\basics\creatures;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface ICreatureProperty
 * 
 * @stage.expand.type ICreatureProperty
 * @stage.expand.name tratabor\interfaces\basics\creatures\ICreatureProperty
 *
 * @stage.name creature.property.init
 * @stage.description Creature property initialization finish
 * @stage.input ICreatureProperty $creatureProperty
 * @stage.output void
 *
 * @stage.name creature.property.after
 * @stage.description Creature property destructing
 * @stage.input ICreatureProperty $creatureProperty
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureProperty extends IItem
{
    const SUBJECT = 'creature.property';
}