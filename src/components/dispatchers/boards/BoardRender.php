<?php
namespace tratabor\components\dispatchers\boards;

use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\interfaces\systems\states\IStateDispatcher;

use tratabor\components\systems\views\ViewRender;
use tratabor\interfaces\basics\contexts\IContextCreatureHero;
use tratabor\interfaces\basics\IBoard;
use tratabor\components\basics\boards\BoardRepository;
use tratabor\interfaces\systems\contexts\IContextRender;

/**
 * Class BoardRender
 *
 * @package tratabor\components\dispatchers\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardRender extends DispatcherAbstract implements IStateDispatcher
{
    protected $requireInterfaces = [
        IContextCreatureHero::class,
        IContextOnFailure::class,
        IContextRender::class
    ];

    /**
     * @param IContext|IContextOnFailure|IContextCreatureHero|IContextRender $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $hero = $context->getHero();
        $boardId = $hero->getBoardId();
        $boards = new BoardRepository();

        /**
         * @var $board IBoard
         */
        $board = $boards->find([IBoard::FIELD__ID => $boardId])->one();

        $viewRender = new ViewRender();
        $cells = $board ? $board->getCells() : [];
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

        $context->setSuccessOn($context->addView($boardRendered));

        return $context;
    }
}
