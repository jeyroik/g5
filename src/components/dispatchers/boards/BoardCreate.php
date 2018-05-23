<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\boards\BoardGenerator;
use tratabor\components\basics\boards\BoardRepository;
use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class BoardCreate
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCreate extends DispatcherAbstract implements IStateDispatcher
{
    /**
     * @param IContext $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        try {
            $context->readItem('board.created');
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
        } catch (\Exception $e) {
            /**
             * todo get x, y, z from the configuration or context-options.
             */
            $board = BoardGenerator::generate(5, 5, 1);
            $repo = new BoardRepository();
            $repo->create($board);
            $repo->commit();

            $context->pushItemByName('board.created', $board);
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
        }

        return $context;
    }
}
