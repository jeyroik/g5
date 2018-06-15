<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\boards\BoardGenerator;
use tratabor\components\basics\boards\BoardRepository;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitContextSuccess;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

/**
 * Class BoardCreate
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardCreate extends DispatcherAbstract implements IStateDispatcher
{
    /**
     * @param IContext $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        try {
            $context->readItem('board.created');
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        } catch (\Exception $e) {
            /**
             * todo get x, y, z from the configuration or context-options.
             */
            $board = BoardGenerator::generate(5, 5, 1);
            $repo = new BoardRepository();
            $repo->create($board);
            $repo->commit();

            $context->pushItemByName('board.created', $board);
            $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);
        }

        return $context;
    }
}
