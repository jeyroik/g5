<?php
namespace tratabor\components\dispatchers\worlds;

use tratabor\components\basics\BasicWorld;
use tratabor\components\basics\worlds\WorldRepository;
use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\systems\IContext;

/**
 * Class WorldCreate
 *
 * @package tratabor\components\dispatchers\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldCreate extends DispatcherAbstract
{
    /**
     * @param IContext $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        try {
            $context->readItem('world');
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);
        } catch (\Exception $e) {
            $repo = new WorldRepository();
            $world = $repo->create(['host' => $_SERVER['SERVER_ADDR']]);

            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
            $context->pushItemByName('world', $world);
        }

        return $context;
    }
}
