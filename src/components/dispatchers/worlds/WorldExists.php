<?php
namespace tratabor\components\dispatchers\worlds;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\contexts\IContextWorld;

/**
 * Class WorldExists
 *
 * @package tratabor\components\dispatchers\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldExists extends DispatcherAbstract implements IStateDispatcher
{
    protected $requireInterfaces = [
        IContextWorld::class,
        IContextOnFailure::class
    ];

    /**
     * @param IContext|IContextOnFailure|IContextWorld $context
     *
     * @return IContext
     * @throws \Exception
     */
    public function dispatch(IContext $context): IContext
    {
        if ($context->isWorldExist()) {
            $context->setSuccess();
        } else {
            $context->setFail();
        }

        return $context;
    }
}
