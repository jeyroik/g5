<?php
namespace tratabor\interfaces\basics\contexts;

use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\IWorld;

/**
 * Interface IContextWorld
 *
 * @package tratabor\interfaces\basics\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextWorld
{
    const CONTEXT_ITEM__WORLD = 'world';

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function isWorldExist(IContext $context = null);

    /**
     * @param IContext|null $context
     *
     * @throws \Exception
     * @return IWorld
     */
    public function findWorld(IContext $context = null);

    /**
     * @param IContext|null $context
     *
     * @return IWorld|null
     */
    public function getWorld(IContext $context = null);

    /**
     * @param IWorld|array $world
     * @param IContext|null $context
     *
     * @return mixed
     */
    public function createWorld($world, IContext &$context = null);
}
