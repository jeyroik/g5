<?php
namespace tratabor\components\dispatchers\worlds;

use tratabor\components\basics\worlds\WorldRepository;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class WorldExists
 *
 * @package tratabor\components\dispatchers\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldExists implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        $worlds = WorldRepository::all();

        if (empty($worlds)) {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);
        } else {
            $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
            $context->pushItemByName('world', array_shift($worlds));
        }

        return $context;
    }
}
