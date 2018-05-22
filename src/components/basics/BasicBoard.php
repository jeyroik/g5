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

    /**
     * @return int
     */
    public function getCreaturesCount(): int
    {
        return $this->data['creatures_count'] ?? 0;
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            'id' => $this->getId(),
            'size' => $this->getSize(),
            'cells' => $this->getCells(),
            'creatures_max' => $this->getCreaturesMax(),
            'creatures' => $this->getCreatures(),
            'creatures_count' => $this->getCreaturesCount(),
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt()
        ];
    }
}
