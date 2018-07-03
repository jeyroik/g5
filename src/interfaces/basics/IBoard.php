<?php
namespace tratabor\interfaces\basics;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IBoard
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IBoard extends IItem
{
    const SUBJECT = 'board';

    /**
     * @return int
     */
    public function getSize(): int;

    /**
     * @return ICell[]
     */
    public function getCells();

    /**
     * @return ICreature[]
     */
    public function getCreatures();

    /**
     * @return int
     */
    public function getCreaturesCount(): int;

    /**
     * @return int
     */
    public function getCreaturesMax(): int;

    /**
     * @return ICell[]
     */
    public function getSpawnCells();

    /**
     * @param ICreature $creature
     *
     * @return ICell cell creature is attached to
     */
    public function attachCreature(ICreature $creature): ICell;
}
