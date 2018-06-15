<?php
namespace tratabor\interfaces\basics;

use tratabor\interfaces\basics\cells\ICellSnag;
use tratabor\interfaces\systems\IItem;

/**
 * Interface ICell
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface ICell extends IItem
{
    /**
     * @return int
     */
    public function getX(): int;

    /**
     * @return int
     */
    public function getY(): int;

    /**
     * @return int
     */
    public function getZ(): int;

    /**
     * @return array [x, y, z]
     */
    public function getCoordinates();

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return bool
     */
    public function isSpawn(): bool;

    /**
     * @return ICellSnag|null
     */
    public function getContain();

    /**
     * @return string
     */
    public function getBoardId(): string;

    /**
     * @param ICreature $creature
     *
     * @return bool
     */
    public function attachCreature(ICreature $creature): bool;
}
