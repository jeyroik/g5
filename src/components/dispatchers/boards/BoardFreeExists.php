<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\BasicBoard;
use tratabor\components\basics\boards\BoardRepository;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use tratabor\components\extensions\basics\boards\BoardExtensionContextFreeBoard;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\basics\IBoard;
use jeyroik\extas\interfaces\systems\IContext;

/**
 * Class BoardFreeExists
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardFreeExists extends DispatcherAbstract
{
    /**
     * @param IContext $context
     *
     * @return IContext
     * @throws \Exception
     */
    protected function dispatch(IContext $context): IContext
    {
        if ($context->isImplementsInterface(BoardExtensionContextFreeBoard::class)) {
            /**
             * @var $context BoardExtensionContextFreeBoard
             */
            $board = $context->getFreeBoard();

            if ($board) {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
            } else {
                $repo = new BoardRepository();

                /**
                 * @var $board IBoard
                 */
                $board = $repo->find([[
                    BasicBoard::FIELD__CREATURES_COUNT,
                    '<',
                    $repo->getName() . '.' . BasicBoard::FIELD__CREATURES_MAX
                ]])->one();

                if ($board->getId()) {
                    $context->setFreeBoard($board);
                    $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
                } else {
                    throw new \Exception('Missed free boards');
                }
            }
        }

        return $context;
    }
}
