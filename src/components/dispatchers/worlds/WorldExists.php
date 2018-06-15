<?php
namespace tratabor\components\dispatchers\worlds;

use tratabor\components\basics\worlds\WorldRepository;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\IState;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

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
        try {
            $context->readItem('world');
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        } catch (\Exception $e) {
            $repo = new WorldRepository();
            $worlds = $repo->find([])->all();

            if (empty($worlds)) {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);
            } else {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
                $context->pushItemByName('world', array_shift($worlds));
            }
        }

        return $context;
    }
}
