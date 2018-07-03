<?php
namespace jeyroik\extas\interfaces\systems\contexts;

use jeyroik\extas\interfaces\systems\IContext;

/**
 * Interface IContextWorld
 *
 * @package jeyroik\extas\interfaces\systems\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextWorld
{
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
     * @param IContext|null $context
     *
     * @return mixed
     */
    public function createWorld(IContext &$context = null);
}
