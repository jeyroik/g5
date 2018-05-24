<?php
namespace tratabor\components\basics\boards;

use tratabor\components\basics\Basic;
use tratabor\interfaces\basics\cells\ICellSnag;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;
use tratabor\interfaces\systems\IItem;

/**
 * Class BoardCell
 *
 * @package tratabor\components\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCell extends Basic implements ICell
{
    const FIELD__ID = 'id';
    const FIELD__X = 'x';
    const FIELD__Y = 'y';
    const FIELD__Z = 'z';
    const FIELD__CONTAIN = 'contain';

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
     * @param ICreature $creature
     *
     * @return bool
     */
    public function attachCreature(ICreature $creature): bool
    {
        if ($this->isEmpty()) {
            $this->data[static::FIELD__CONTAIN] = $creature;

            return true;
        }

        return false;
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
            'id' => $this->getId(),
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
