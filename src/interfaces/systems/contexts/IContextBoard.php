<?php
namespace jeyroik\extas\interfaces\systems\contexts;

use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\IBoard;

/**
 * Interface IContextBoard
 *
 * @package jeyroik\extas\interfaces\systems\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextBoard
{
    /**
     * @param $context IContext
     *
     * @return IBoard|bool
     */
    public function getFreeBoard(IContext &$context = null);

    /**
     * @param IBoard $board
     * @param IContext|null $context
     *
     * @return bool
     */
    public function setFreeBoard(IBoard $board, IContext &$context = null);
}
