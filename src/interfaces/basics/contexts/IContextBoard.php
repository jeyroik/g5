<?php
namespace tratabor\interfaces\basics\contexts;

use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\basics\IBoard;

/**
 * Interface IContextBoard
 *
 * @package tratabor\interfaces\basics\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextBoard
{
    const CONTEXT_ITEM__BOARD_FREE = 'board.free';
    const CONTEXT_ITEM__BOARD_CREATED = 'board.created';

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasFreeBoard(IContext &$context = null): bool;

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
    public function setFreeBoard(IBoard $board, IContext &$context = null): bool;

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasCreatedBoard(IContext &$context = null): bool;

    /**
     * @param $x
     * @param $y
     * @param $z
     * @param IContext|null $context
     *
     * @return IBoard
     */
    public function createBoard($x, $y, $z, IContext &$context = null);
}
