<?php
namespace tratabor\components\dispatchers\creatures;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;
use tratabor\interfaces\systems\contexts\IContextBoard;

/**
 * Class CreatureHeroBoardAttachTo
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroBoardAttachTo extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextCreatureHero::class,
        IContextBoard::class
    ];

    /**
     * @param IContext|IContextOnFailure|IContextBoard|IContextCreatureHero $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        if ($context->hasHero() && $context->hasFreeBoard()) {
            $context->setSuccessOn($context->attachHeroToFreeBoard());
        } else {
            $context->setFail();
        }

        return $context;
    }
}
