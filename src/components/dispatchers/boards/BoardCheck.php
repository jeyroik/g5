<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class BoardCheck
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCheck implements IStateDispatcher
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
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);
        }

        return $context;
    }
}
