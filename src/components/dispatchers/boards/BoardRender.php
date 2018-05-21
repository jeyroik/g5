<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\components\systems\views\ViewRender;
use tratabor\interfaces\basics\IBoard;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class BoardRender
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardRender extends DispatcherAbstract implements IStateDispatcher
{
    /**
     * @param IContext $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        /**
         * @var $board IBoard
         */
        $board = $context->readItem('board')->getValue();
        $viewRender = new ViewRender();
        $cells = $board->getCells();
        $rows = [];
        $boardRendered = '';

        foreach ($cells as $cell) {
            if (!isset($rows[$cell->getY()])) {
                $rows[$cell->getY()] = '';
            }

            $rows[$cell->getY()] .= $viewRender->render('board/cell', ['cell' => $cell]);
        }

        foreach ($rows as $row) {
            $boardRendered .= $viewRender->render('board/row', ['cells' => $row]);
        }

        try {
            $views = $context->readItem('html')->getValue();
            $views[] = $boardRendered;
            $context->updateItem('html', $views);
        } catch (\Exception $e) {
            $views = [$boardRendered];
            $context->pushItemByName('html', $views);
        }
        $context->updateItem(IStateMachine::CONTEXT__SUCCESS, true);

        return $context;
    }
}
