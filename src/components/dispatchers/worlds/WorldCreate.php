<?php
namespace tratabor\components\dispatchers\worlds;

use tratabor\components\dispatchers\DispatcherAbstract;
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

        return $context;
    }
}
