<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\interfaces\basics\creatures\ICreatureHero;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class BoardHeroAttach
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardHeroAttach extends DispatcherAbstract
{
    /**
     * @param IContext $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $board = $context->readItem('board.free')->getValue();

        /**
         * @var $hero ICreatureHero
         */
        $hero = $context->readItem('hero')->getValue();
        $hero->attachToBoard($board);

        $context->updateItem('hero', $hero);
        $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);

        return $context;
    }
}
