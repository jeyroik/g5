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
    const SUBJECT = 'world';

    const FIELD__NAME = 'name';
    const FIELD__HOST = 'host';
    const FIELD__BOARDS_MAX = 'boards_max';
    const FIELD__BOARDS_CURRENT = 'boards_current';
    const FIELD__CREATURES_MAX = 'creatures_max';
    const FIELD__CREATURES_CURRENT = 'creatures_current';
    const FIELD__SIZE = 'size';

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