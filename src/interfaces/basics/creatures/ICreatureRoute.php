<?php
namespace tratabor\interfaces\basics\creatures;

use tratabor\interfaces\basics\ICell;
use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface ICreatureRoute
 *
 * @stage.expand.type ICreatureRoute
 * @stage.expand.name tratabor\interfaces\basics\creatures\ICreatureRoute
 *
 * @stage.name creature.route.init
 * @stage.description Creature route initialization finish
 * @stage.input ICreatureRoute $creatureRoute
 * @stage.output void
 *
 * @stage.name creature.route.after
 * @stage.description Creature route destructing
 * @stage.input ICreatureRoute $creatureRoute
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureRoute extends IItem
{
    const SUBJECT = 'creature.route';

    /**
     * @param ICell $cell
     *
     * @return mixed
     */
    public function addStep(ICell $cell);

    /**
     * @return ICell|null
     */
    public function getCurrentPosition();
}
