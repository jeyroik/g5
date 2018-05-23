<?php
namespace tratabor\components\basics\boards;

use tratabor\components\basics\Basic;
use tratabor\interfaces\basics\cells\ICellSnag;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\systems\IItem;

/**
 * Class BoardCell
 *
 * @package tratabor\components\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCell extends Basic implements ICell
{
    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->data['x'] ?? 0;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->data['y'] ?? 0;
    }

    /**
     * @return int
     */
    public function getZ(): int
    {
        return $this->data['z'] ?? 0;
    }

    /**
     * @return ICellSnag|null
     */
    public function getContain()
    {
        return $this->data['contain'] ?: null;
    }

    /**
     * @return array
     */
    public function getCoordinates()
    {
        return [$this->getX(), $this->getY(), $this->getZ()];
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return !$this->getContain();
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        $contain = $this->getContain();

        if ($contain && ($contain instanceof IItem)) {
            $contain = $contain->__toArray();
        }

        return [
            'x' => $this->getX(),
            'y' => $this->getY(),
            'z' => $this->getZ(),
            'contain' => $contain,
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'state' => $this->getCurrentStateId()
        ];
    }
}
