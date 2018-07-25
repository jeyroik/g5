<?php
namespace tratabor\components\dispatchers\boards;

use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextBoard;

/**
 * Class BoardFreeExists
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardFreeExists extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextBoard::class,
        IContextOnFailure::class
    ];

    /**
     * @param IContext|IContextBoard|IContextOnFailure $context
     *
     * @return IContext
     * @throws \Exception
     */
    protected function dispatch(IContext $context): IContext
    {
        $context->setSuccessOn($context->hasFreeBoard());

        return $context;
    }
}
