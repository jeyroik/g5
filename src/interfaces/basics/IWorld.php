<?php
namespace tratabor\interfaces\basics;

use tratabor\interfaces\basics\worlds\IWorldHost;
use tratabor\interfaces\systems\IItem;

/**
 * Interface IWorld
 *
 * @package tratabor\interfaces\basics
 * @author Funcraft <me@funcraft.ru>
 */
interface IWorld extends IItem
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return IWorldHost
     */
    public function getHost();

    /**
     * @return IBoard[]
     */
    public function getBoards();

    /**
     * @return int
     */
    public function getBoardsMax(): int;

    /**
     * @return ICreature[]
     */
    public function getCreatures();

    /**
     * @return int
     */
    public function getCreaturesMax(): int;

    /**
     * @return int
     */
    public function getSize(): int;
}