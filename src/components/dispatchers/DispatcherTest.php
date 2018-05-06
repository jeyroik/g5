<?php
namespace tratabor\components\dispatchers;

use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;


/**
 * Class DispatcherTest
 * 
 * @package tratabor\components\dispatchers
 * @author Funcraft <me@funcraft.ru>
 */
class DispatcherTest implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     * 
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        echo 'Current state: <pre>';
        print_r($currentState);
        echo '</pre>';
        
        echo 'Current context: <pre>';
        print_r($context);
        echo '</pre>';
        
        $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
        
        return $context;
    }
}
