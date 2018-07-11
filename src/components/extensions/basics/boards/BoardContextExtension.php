<?php
namespace tratabor\components\extensions\basics\boards;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use tratabor\components\basics\boards\BoardGenerator;
use tratabor\components\basics\boards\BoardRepository;
use tratabor\interfaces\basics\contexts\IContextBoard;
use tratabor\interfaces\basics\IBoard;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class BoardExtensionContextFreeBoard
 *
 * @package tratabor\components\extensions\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardContextExtension extends Extension implements IContextBoard
{
    public $methods = [
        'getFreeBoard' => BoardContextExtension::class,
        'setFreeBoard' => BoardContextExtension::class,
        'hasFreeBoard' => BoardContextExtension::class
    ];

    public $subject = IContext::SUBJECT;

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasFreeBoard(IContext &$context = null): bool
    {
        return isset($context[static::CONTEXT_ITEM__BOARD_FREE]);
    }

    /**
     * @param $context IContext
     *
     * @return IBoard|bool
     */
    public function getFreeBoard(IContext &$context = null)
    {
        if (isset($context[static::CONTEXT_ITEM__BOARD_FREE])) {
            return $context[static::CONTEXT_ITEM__BOARD_FREE];
        }

        return false;
    }

    /**
     * @param IBoard $board
     * @param IContext|null $context
     *
     * @return bool
     */
    public function setFreeBoard(IBoard $board, IContext &$context = null): bool
    {
        $context[static::CONTEXT_ITEM__BOARD_FREE] = $board;

        return true;
    }

    /**
     * @param IContext|null $context
     *
     * @return bool
     */
    public function hasCreatedBoard(IContext &$context = null): bool
    {
        return isset($context[static::CONTEXT_ITEM__BOARD_CREATED]);
    }

    /**
     * @param $x
     * @param $y
     * @param $z
     * @param IContext|IContextOnFailure|null $context
     *
     * @return IBoard
     */
    public function createBoard($x, $y, $z, IContext &$context = null)
    {
        $board = BoardGenerator::generate(5, 5, 1);
        $repo = new BoardRepository();
        $repo->create($board);
        $context[static::CONTEXT_ITEM__BOARD_CREATED] = $board;
        $context->setSuccess();

        return $board;
    }
}
