<?php
namespace tratabor\components\dispatchers;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class DispatcherAbstract
 *
 * @package tratabor\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
abstract class DispatcherAbstract implements IStateDispatcher
{
    /**
     * @var IState
     */
    protected $currentState = null;

    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        try {
            $this->currentState = $currentState;
            $context = $this->dispatch($context);
        } catch (\Exception $e) {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);
        }

        return $context;
    }

    /**
     * @param IContext $context
     *
     * @return IContext
     */
    abstract protected function dispatch(IContext $context): IContext;
}
