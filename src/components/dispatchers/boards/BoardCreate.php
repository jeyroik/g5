<?php
namespace tratabor\components\dispatchers\boards;

use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\contexts\IContextBoard;

/**
 * Class BoardCreate
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCreate extends DispatcherAbstract implements IStateDispatcher
{
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextBoard::class
    ];

    /**
     * @param IContext|IContextBoard|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $context->hasCreatedBoard()
            ? $context->setSuccess()
            : $context->setSuccessOn($context->createBoard(5, 5, 1)->getSize());

        return $context;
    }
}
