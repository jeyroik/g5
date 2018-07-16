<?php
namespace tratabor\components\dispatchers\worlds;

use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\IWorld;
use tratabor\interfaces\basics\contexts\IContextWorld;

/**
 * Class WorldCreate
 *
 * @package tratabor\components\dispatchers\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldCreate extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextWorld::class,
        IContextOnFailure::class
    ];

    /**
     * @param IContext|IContextWorld|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        if ($context->isWorldExist()) {
            $context->setFail();
        } else {
            $context->createWorld([IWorld::FIELD__HOST => $_SERVER['SERVER_NAME']]);
            $context->setSuccess();
        }

        return $context;
    }
}
