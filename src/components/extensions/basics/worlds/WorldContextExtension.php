<?php
namespace tratabor\components\extensions\basics\worlds;

use jeyroik\extas\components\systems\Extension;
use tratabor\interfaces\basics\contexts\IContextWorld;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\components\basics\worlds\WorldRepository;
use tratabor\interfaces\basics\IWorld;

/**
 * Class WorldContext
 *
 * @package tratabor\components\extensions\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldContextExtension extends Extension implements IContextWorld
{
    public $methods = [
        'getWorld' => WorldContextExtension::class,
        'isWorldExist' => WorldContextExtension::class,
        'findWorld' => WorldContextExtension::class,
        'createWorld' => WorldContextExtension::class
    ];

    public $subject = IContext::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function isWorldExist(IContext $context = null)
    {
        return $context && isset($context[static::CONTEXT_ITEM__WORLD]);
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
            return $context[static::CONTEXT_ITEM__WORLD];
        }

        return null;
    }

    /**
     * @param IWorld|array $world
     * @param IContext|null $context
     *
     * @return mixed
     */
    public function createWorld($world, IContext &$context = null)
    {
        $repo = new WorldRepository();
        try {
            $world = $repo->create($world);
            $context[static::CONTEXT_ITEM__WORLD] = $world;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $world;
    }
}
