<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\boards\BoardRepository;
use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateMachine;

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
        try {
            $context->readItem('board.free')->getValue();
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        } catch (\Exception $e) {
            $repo = new BoardRepository();

            /**
             * @var $board IBoard
             */
            $board = $repo->find([
                $repo->getName() . '.creatures_count',
                '<',
                $repo->getName() . '.creatures_max'
            ])->one();

            if ($board->getId()) {
                $context->pushItemByName('board.free', $board);
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
            } else {
                $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);
                throw new \Exception('Missed free boards');
            }
        }

        return $context;
    }
}
