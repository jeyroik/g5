<?php
namespace tratabor\components\basics\creatures;

use tratabor\components\basics\BasicCreature;
use tratabor\components\basics\BasicRepository;
use tratabor\interfaces\basics\ICreature;

/**
 * Class CreatureRepository
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureRepository extends BasicRepository
{
    /**
     * @param $itemConfig
     *
     * @return ICreature
     */
    public static function create($itemConfig)
    {
        return static::getInstance()->createItem($itemConfig);
    }

    /**
     * @param $itemConfig
     *
     * @return BasicCreature
     */
    public function createItem($itemConfig)
    {
        return new BasicCreature($itemConfig);
    }

    /**
     * @return string
     */
    protected function getItemClass(): string
    {
        return BasicCreature::class;
    }

    /**
     * @return string
     */
    protected function getPathKey(): string
    {
        return 'G5__CREATURES__PATH';
    }

    /**
     * @return string
     */
    protected function getPathDefault(): string
    {
        return G5__ROOT_PATH . '/resources/creatures.php';
    }
}
