<?php
namespace tratabor\interfaces\basics\worlds;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IWorldHost
 *
 * @stage.expand.type IWorldHost
 * @stage.expand.name tratabor\interfaces\basics\worlds\IWorldHost
 *
 * @stage.name world.host.init
 * @stage.description World host initialization finish
 * @stage.input IWorldHost $worldHost
 * @stage.output void
 *
 * @stage.name world.host.after
 * @stage.description World host destructing
 * @stage.input IWorldHost $worldHost
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
interface IWorldHost extends IItem
{
    const SUBJECT = 'world.host';

    const FIELD__NAME = 'name';
    const FIELD__IP = 'ip';
    const FIELD__STATE = 'state';

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getIp();

    /**
     * @return string
     */
    public function getState();

    /**
     * @return array
     */
    public function __toArray(): array;
}
