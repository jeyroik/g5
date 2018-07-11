<?php
namespace tratabor\components\dispatchers\creatures;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;
use tratabor\interfaces\basics\contexts\IContextProfile;

class CreatureHeroChoose extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextOnFailure::class
    ];

    /**
     * @param IContext|IContextProfile|IContextCreatureHero|IContextOnFailure $context
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $profile = $context->getProfile();
        $heroes = $profile->getHeroes();

        if (!empty($heroes)) {
            $hero = array_shift($heroes);
            $context->setHero($hero);
            $context->setSuccess();
        } else {
            $context->setFail();
        }

        return $context;
    }
}
