<?php
namespace tratabor\components\extensions\basics\creatures;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;
use tratabor\interfaces\basics\contexts\IContextBoard;
use tratabor\interfaces\basics\contexts\IContextProfile;

/**
 * Class CreatureContextExtension
 *
 * @package tratabor\components\extensions\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureContextExtension extends Extension implements IContextCreatureHero
{
    public $methods = [
        'hasHero' => CreatureContextExtension::class,
        'getHero' => CreatureContextExtension::class,
        'attachHeroToFreeBoard' => CreatureContextExtension::class
    ];

    public $subject = IContext::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasHero(IContext &$context = null): bool
    {
        return isset($context[static::CONTEXT_ITEM__HERO]);
    }

    /**
     * @param IContext|null $context
     *
     * @return mixed
     * @throws \Exception
     */
    public function getHero(IContext &$context = null)
    {
        $hero = $context[static::CONTEXT_ITEM__HERO];

        if (!$hero) {
            throw new \Exception('Missed hero in the current context');
        }

        return $hero;
    }

    /**
     * @param $hero
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setHero($hero, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__HERO] = $hero;

        return $context;
    }

    /**
     * @param IContext|IContextBoard $context
     * @return bool
     */
    public function attachHeroToFreeBoard(IContext &$context = null): bool
    {
        $board = $context->getFreeBoard();
        $hero = $this->getHero($context);
        $hero->attachToBoard($board);
        $this->setHero($hero, $context);

        return true;
    }

    /**
     * @param IContext|null|IContextProfile|IContextCreatureHero $context
     *
     * @return bool
     */
    public function addHeroToProfile(IContext &$context = null): bool
    {
        $profile = $context->getProfile();
        $hero = $context->getHero();

        $profile->addCreature($hero);
        $context->setProfile($profile);

        return true;
    }
}
