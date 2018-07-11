<?php
namespace tratabor\components\dispatchers\creatures;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;

/**
 * Class CreatureHeroBoardCheck
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroBoardCheck extends DispatcherAbstract
{
    /**
     * @var array
     */
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextCreatureHero::class
    ];

    /**
     * @param IContext|IContextCreatureHero|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $context->setSuccessOn($context->getHero()->getBoardId());

        return $context;
    }
}
