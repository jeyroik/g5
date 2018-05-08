<?php
namespace tratabor\interfaces\basics;

use tratabor\interfaces\systems\IItem;

/**
 * Interface IBoard
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IBoard extends IItem
{
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
    public function getCreaturesMax(): int;
}
