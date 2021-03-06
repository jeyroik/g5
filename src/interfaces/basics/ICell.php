<?php
namespace tratabor\interfaces\basics;

use tratabor\interfaces\basics\cells\ICellSnag;
use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface ICell
 *
 * @stage.expand.type ICell
 * @stage.expand.name tratabor\interfaces\basics\ICell
 *
 * @stage.name board.cell.init
 * @stage.description Cell initialization finish
 * @stage.input ICell $cell
 * @stage.output void
 *
 * @stage.name board.cell.after
 * @stage.description Cell destructing
 * @stage.input ICell $cell
 * @stage.output void
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface ICell extends IItem
{
    const SUBJECT = 'board.cell';

    /**
     * @return mixed
     */
    public function getId();

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

    /**
     * @return array
     */
    public function getCrashes(): array;
}
