<?php
namespace tratabor\components\extensions\basics\worlds;

use jeyroik\extas\components\systems\Extension;
use tratabor\interfaces\systems\contexts\IContextWorld;
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
    const CONTEXT__ITEM__WORLD = 'world';

    public $methods = [
        'getWorld' => WorldContextExtension::class,
        'isWorldExist' => WorldContextExtension::class,
        'findWorld' => WorldContextExtension::class,
        'createWorld' => WorldContextExtension::class
    ];

    public $subject = IWorld::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function isWorldExist(IContext $context = null)
    {
        return $context && isset($context[static::CONTEXT__ITEM__WORLD]);
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
            return $context[static::CONTEXT__ITEM__WORLD];
        }

        return null;
    }

    public function createWorld(IContext &$context = null)
    {

    }
}
