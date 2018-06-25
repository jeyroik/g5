<?php
namespace tratabor\components\extensions\basics\worlds;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\components\basics\worlds\WorldRepository;
use tratabor\interfaces\basics\IWorld;

/**
 * Class WorldContext
 *
 * @package tratabor\components\extensions\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldContext extends Extension
{
    const CONTEXT__ITEM__WORLD = 'world';

    protected $methods = [
        'getWorld' => WorldContext::class,
        'isWorldExist' => WorldContext::class,
        'findWorld' => WorldContext::class,
        'createWorld' => WorldContext::class
    ];

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function isWorldExist(IContext $context = null)
    {
        return $context && $context->hasItem(static::CONTEXT__ITEM__WORLD);
    }

    /**
     * @param IContext|null $context
     *
     * @throws \Exception
     * @return IWorld
     */
    public function findWorld(IContext $context = null)
    {
        $repo = new WorldRepository();
        $worlds = $repo->find(['boards_max', '>', $repo->getName() . '.boards_current'])->all();

        if (empty($worlds)) {
            throw new \Exception('There is no worlds or all worlds are full.');
        }

        return array_shift($worlds);
    }

    /**
     * @param IContext|null $context
     *
     * @return IWorld|null
     */
    public function getWorld(IContext $context = null)
    {
        if ($this->isWorldExist($context)) {
            return $context->readItem(static::CONTEXT__ITEM__WORLD)->getValue();
        }

        return null;
    }

    public function createWorld(IContext &$context = null)
    {

    }
}
