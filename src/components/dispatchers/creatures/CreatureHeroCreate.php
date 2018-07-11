<?php
namespace tratabor\components\dispatchers\creatures;

use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;
use tratabor\interfaces\basics\contexts\IContextProfile;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class CreatureHeroCreate
 *
 * @package tratabor\components\dispatchers\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureHeroCreate extends DispatcherAbstract implements IStateDispatcher
{
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextCreatureHero::class,
        IContextProfile::class
    ];

    /**
     * @param IContext|IContextCreatureHero|IContextOnFailure|IContextProfile $context
     * @return IContext
     * @throws \Exception
     */
    protected function dispatch(IContext $context): IContext
    {
        !$context->hasHero() && $context->createHero([
            'name' => 'Hero #' . time(),
            'type' => 'hero',
            'avatar' => 'https://image.freepik.com/free-icon/no-translate-detected_318-9118.jpg',
            'level_current' => 0,
            'exp_current' => 0,
            'level_next' => 1,
            'exp_next' => 1,
            'skills' => [],
            'properties' => [],
            'board_id' => 0,
            'inventory' => [],
            'route' => [],
            'skills_max' => 1,
            'properties_max' => 1,
            'characteristics_max' => 3
        ]);

        $context->setSuccessOn($context->addHeroToProfile());

        return $context;
    }
}
