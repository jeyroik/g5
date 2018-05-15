<?php
namespace tratabor\components\basics\creatures;

use tratabor\interfaces\basics\creatures\ICreatureInventory;

/**
 * Class CreatureInventory
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureInventory implements ICreatureInventory
{
    /**
     * @var array
     */
    protected $inventory = [];

    /**
     * @var array
     */
    protected $items = [];

    /**
     * CreatureInventory constructor.
     * @param $inventoryConfig
     */
    public function __construct($inventoryConfig)
    {
        $this->initInventory($inventoryConfig);
    }

    /**
     * @param $inventoryConfig
     *
     * @return $this
     */
    protected function initInventory($inventoryConfig)
    {
        $this->inventory = $inventoryConfig;

        return $this;
    }
}
