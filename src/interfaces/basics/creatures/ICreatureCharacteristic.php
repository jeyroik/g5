<?php
namespace tratabor\interfaces\basics\creatures;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface ICreatureCharacteristic
 * 
 * @stage.expand.type ICreatureCharacteristics
 * @stage.expand.name tratabor\interfaces\basics\creatures\ICreatureCharacteristics
 *
 * @stage.name creature.characteristics.init
 * @stage.description Creature characteristics initialization finish
 * @stage.input ICreatureCharacteristics $creatureCharacteristics
 * @stage.output void
 *
 * @stage.name creature.characteristics.after
 * @stage.description Creature characteristics destructing
 * @stage.input ICreatureCharacteristics $creatureCharacteristics
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureCharacteristic extends IItem
{
    const SUBJECT = 'creature.characteristics';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return string
     */
    public function getDescription(): string;
}
