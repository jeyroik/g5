<?php
namespace tratabor\components\dispatchers\boards;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\basics\creatures\ICreatureHero;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use jeyroik\extas\interfaces\systems\states\IStateMachine;

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
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        } else {
            throw new \Exception('Hero is not attached to a board');
        }

        return $context;
    }
}
