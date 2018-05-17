<?php
namespace tratabor\components\basics;

use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;

/**
 * Class BasicBoard
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicBoard extends Basic implements IBoard
{
    /**
     * @return string
     */
    public function getId()
    {
        return $this->data['id'] ?? '';
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->data['size'] ?? 0;
    }

    /**
     * @return ICell[]
     */
    public function getCells()
    {
        return $this->data['cells'] ?? [];
    }

    /**
     * @return int
     */
    public function getCreaturesMax(): int
    {
        return $this->data['creatures_max'] ?? 1;
    }

    /**
     * @return ICreature[]
     */
    public function getCreatures()
    {
        return $this->data['creatures'] ?? [];
    }
}
