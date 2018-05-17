<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\boards\BoardGenerator;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class BoardCreate
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCreate implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        try {
            $context->readItem('board');
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
        } catch (\Exception $e) {
            /**
             * todo get x, y, z from the configuration or context-options.
             */
            $board = BoardGenerator::generate(5, 5, 1);
            $context->pushItemByName('board', $board);
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
        }

        return $context;
    }
}
