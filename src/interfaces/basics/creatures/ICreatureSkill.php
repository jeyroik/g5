<?php
namespace tratabor\interfaces\basics\creatures;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface ICreatureSkill
 *
 * @stage.expand.type ICreatureSkill
 * @stage.expand.name tratabor\interfaces\basics\creatures\ICreatureSkill
 *
 * @stage.name creature.skill.init
 * @stage.description Creature skill initialization finish
 * @stage.input ICreatureSkill $creatureSkill
 * @stage.output void
 *
 * @stage.name creature.skill.after
 * @stage.description Creature skill destructing
 * @stage.input ICreatureSkill $creatureSkill
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureSkill extends IItem
{
    const SUBJECT = 'creature.skill';
}
