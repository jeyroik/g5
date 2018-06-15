<?php
namespace tratabor\components\extensions\basics\boards;

use tratabor\components\systems\Extension;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\systems\IContext;

/**
 * Class BoardExtensionContextFreeBoard
 *
 * @package tratabor\components\extensions\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardExtensionContextFreeBoard extends Extension
{
    const CONTEXT_ITEM__FREE_BOARD = 'board.free';

    protected $methods = [
        'getFreeBoard' => BoardExtensionContextFreeBoard::class,
        'setFreeBoard' => BoardExtensionContextFreeBoard::class,
    ];

    /**
     * @param $context IContext
     *
     * @return IBoard|bool
     */
    public function getFreeBoard(IContext &$context = null)
    {
        if ($context->hasItem(static::CONTEXT_ITEM__FREE_BOARD)) {
            return $context->readItem(static::CONTEXT_ITEM__FREE_BOARD)->getValue();
        }

        return false;
    }

    /**
     * @param IBoard $board
     * @param IContext|null $context
     *
     * @return bool
     */
    public function setFreeBoard(IBoard $board, IContext $context = null)
    {
        $context->pushItemByName(static::CONTEXT_ITEM__FREE_BOARD, $board);

        return true;
    }
}
