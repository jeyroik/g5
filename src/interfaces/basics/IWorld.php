<?php
namespace tratabor\interfaces\basics;

use tratabor\interfaces\basics\worlds\IWorldHost;
use jeyroik\extas\interfaces\systems\IItem;

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
     * @return int
     */
    public function getBoardsMax(): int;

    /**
     * @return int
     */
    public function getBoardsCurrent(): int;

    /**
     * @return int
     */
    public function getCreaturesMax(): int;

    /**
     * @return int
     */
    public function getCreaturesCurrent(): int;

    /**
     * @return int
     */
    public function getSize(): int;
}