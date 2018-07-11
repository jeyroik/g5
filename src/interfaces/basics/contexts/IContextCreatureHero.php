<?php
namespace tratabor\interfaces\basics\contexts;

use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\creatures\ICreatureHero;

/**
 * Interface IContextCreatureHero
 *
 * @package tratabor\interfaces\basics\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextCreatureHero
{
    const CONTEXT_ITEM__HERO = 'hero';

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasHero(IContext &$context = null): bool;

    /**
     * @param IContext|null $context
     *
     * @return ICreatureHero
     */
    public function getHero(IContext &$context = null);

    /**
     * @param $hero
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setHero($hero, IContext &$context = null);

    /**
     * @param $hero
     * @param IContext|null $context
     *
     * @return ICreatureHero
     */
    public function createHero($hero, IContext &$context = null);

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function attachHeroToFreeBoard(IContext &$context = null): bool;

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function addHeroToProfile(IContext &$context = null): bool;
}
