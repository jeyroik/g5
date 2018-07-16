<?php
namespace tratabor\interfaces\basics;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IBoard
 *
 * @stage.expand.type IBoard
 * @stage.expand.name tratabor\interfaces\basics\IBoard
 *
 * @stage.name board.init
 * @stage.description Board initialization finish
 * @stage.input IBoard $board
 * @stage.output void
 *
 * @stage.name board.after
 * @stage.description Board destructing
 * @stage.input IBoard $board
 * @stage.output void
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IBoard extends IItem
{
    const SUBJECT = 'board';

    const FIELD__SIZE = 'size';
    const FIELD__CELLS = 'cells';
    const FIELD__CREATURES = 'creatures';
    const FIELD__CREATURES_COUNT = 'creatures_count';
    const FIELD__CREATURES_MAX = 'creatures_max';
    const FIELD__ID = 'id';

    /**
     * @return mixed
     */
    public function getId();

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
