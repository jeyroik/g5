<?php
namespace tratabor\components\basics\boards;

use tratabor\components\basics\Basic;
use tratabor\components\basics\BasicSnag;
use tratabor\interfaces\basics\cells\ICellSnag;
use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\basics\ICreature;
use jeyroik\extas\interfaces\systems\IItem;

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
    const FIELD__BOARD_ID = 'board_id';
    const FIELD__IS_SPAWN = 'is_spawn';

    protected $crashes = [];

    /**
     * @return int
     */
    public function getX(): int
    {
        return $this->config[static::FIELD__X] ?? 0;
    }

    /**
     * @return int
     */
    public function getY(): int
    {
        return $this->config[static::FIELD__Y] ?? 0;
    }

    /**
     * @return int
     */
    public function getZ(): int
    {
        return $this->config[static::FIELD__Z] ?? 0;
    }

    /**
     * @return ICellSnag|null
     */
    public function getContain()
    {
        $contain = $this->config[static::FIELD__CONTAIN] ?: null;

        if (($contain) && (is_array($contain))) {
            $snagClass = $contain['class'] ?? BasicSnag::class;
            $contain = new $snagClass($contain);
        }

        return $contain;
    }

    /**
     * @return string
     */
    public function getBoardId(): string
    {
        return $this->config[static::FIELD__BOARD_ID] ?? '';
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
     * @return bool
     */
    public function isSpawn(): bool
    {
        return $this->config[static::FIELD__IS_SPAWN] ?? false;
    }

    /**
     * @param ICreature $creature
     *
     * @return bool
     */
    public function attachCreature(ICreature $creature): bool
    {
        if ($this->isEmpty()) {
            $this->config[static::FIELD__CONTAIN] = $creature;

            return true;
        } else {
            $this->crashes[] = 'Not empty cell';
        }

        return false;
    }

    /**
     * @return array
     */
    public function getCrashes(): array
    {
        return $this->crashes;
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
            static::FIELD__ID => $this->getId(),
            static::FIELD__X => $this->getX(),
            static::FIELD__Y => $this->getY(),
            static::FIELD__Z => $this->getZ(),
            static::FIELD__CONTAIN => $contain,
            'created_at' => $this->getCreatedAt(),
            'updated_at' => $this->getUpdatedAt(),
            'state' => 'not implemented yet',
            'board_id' => $this->getBoardId()
        ];
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return ICell::SUBJECT;
    }
}
