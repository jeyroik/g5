<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\interfaces\systems\IContext;

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
     */
    protected function dispatch(IContext $context): IContext
    {
        /**
         * $board = BoardRepository::find(['creatures.count' > 0])->one();
         * if ($board) {
         *      $context->pushItemByName('board.free', $board);
         *      $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);
         * } else {
         *      throw new \Exception('Missed free boards');
         * }
         */

        return $context;
    }
}
