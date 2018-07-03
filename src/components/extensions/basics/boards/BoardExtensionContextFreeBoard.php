<?php
namespace tratabor\components\extensions\basics\boards;

use jeyroik\extas\components\systems\Extension;
use tratabor\interfaces\systems\contexts\IContextBoard;
use tratabor\interfaces\basics\IBoard;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class BoardExtensionContextFreeBoard
 *
 * @package tratabor\components\extensions\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardExtensionContextFreeBoard extends Extension implements IContextBoard
{
    const CONTEXT_ITEM__FREE_BOARD = 'board.free';

    public $methods = [
        'getFreeBoard' => BoardExtensionContextFreeBoard::class,
        'setFreeBoard' => BoardExtensionContextFreeBoard::class,
    ];

    public $subject = IBoard::SUBJECT;

    /**
     * @param $context IContext
     *
     * @return IBoard|bool
     */
    public function getFreeBoard(IContext &$context = null)
    {
        if (isset($context[static::CONTEXT_ITEM__FREE_BOARD])) {
            return $context[static::CONTEXT_ITEM__FREE_BOARD];
        }

        return false;
    }

    /**
     * @param IBoard $board
     * @param IContext|null $context
     *
     * @return bool
     */
    public function setFreeBoard(IBoard $board, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__FREE_BOARD] = $board;

        return true;
    }
}
