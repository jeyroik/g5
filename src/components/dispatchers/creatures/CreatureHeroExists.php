<?php
namespace tratabor\components\dispatchers\creatures;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;
use tratabor\interfaces\basics\contexts\IContextProfile;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class CreatureHeroExists
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroExists extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextCreatureHero::class,
        IContextProfile::class
    ];

    /**
     * @param IContext|IContextCreatureHero|IContextOnFailure|IContextProfile $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $profile = $context->getProfile();
        $heroes = $profile ? $profile->getHeroes() : [];

        $context->setFailOn(empty($heroes));

        return $context;
    }
}
