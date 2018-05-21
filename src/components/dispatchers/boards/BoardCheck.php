<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\interfaces\basics\creatures\ICreatureHero;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\basics\users\IUserProfile;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class BoardCheck
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCheck extends DispatcherAbstract implements IStateDispatcher
{
    /**
     * @param IContext $context
     *
     * @return IContext
     * @throws \Exception
     */
    protected function dispatch(IContext $context): IContext
    {
        /**
         * @var $hero ICreatureHero
         */
        $hero = $context->readItem('hero')->getValue();

        if ($hero->getBoardId()) {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
        } else {
            throw new \Exception('Hero is not attached to a board');
        }

        return $context;
    }
}
