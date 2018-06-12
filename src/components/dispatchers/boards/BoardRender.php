<?php
namespace tratabor\components\dispatchers\boards;

use tratabor\components\basics\boards\BoardRepository;
use tratabor\components\dispatchers\DispatcherAbstract;
use tratabor\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\components\systems\views\ViewRender;
use tratabor\interfaces\basics\creatures\ICreatureHero;
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
         * @var $hero ICreatureHero
         */
        $hero = $context->readItem('hero')->getValue();
        $boardId = $hero->getBoardId();
        $boards = new BoardRepository();

        /**
         * @var $board IBoard
         */
        $board = $boards->find(['id' => $boardId])->one();

        $viewRender = new ViewRender();
        $cells = $board->getCells();
        $rows = [];
        $boardRendered = 'Board #' . $boardId;

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
        $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);

        return $context;
    }
}
