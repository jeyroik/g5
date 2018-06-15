<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\boards\BoardRepository;
use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\components\systems\states\machines\plugins\PluginInitContextSuccess;
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
        $repo = new BoardRepository();
        $board = $repo->find(['creatures_count', '<', 'creatures_max'])->one();

        if ($board) {
            $context->pushItemByName('board.free', $board);
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        } else {
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, false);
            throw new \Exception('Missed free boards');
        }

        return $context;
    }
}
