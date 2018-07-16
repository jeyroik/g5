<?php
namespace tratabor\interfaces\systems\views;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface IViewRender
 *
 * @stage.expand.type IRender
 * @stage.expand.name tratabor\interfaces\systems\views\IViewRender
 *
 * @stage.name view.init
 * @stage.description View render initialization finish
 * @stage.input IRender $render
 * @stage.output void
 *
 * @stage.name view.after
 * @stage.description View render destructing
 * @stage.input IRender $render
 * @stage.output void
 *
 * @stage.name view.path
 * @stage.description view path constructing
 * @stage.input IRender $render, string $currentPath
 * @stage.output string $viewPath
 *
 * @stage.name view.render.before
 * @stage.description before view parameters exporting and view rendering
 * @stage.input  IRender &$render, string $viewPath
 * @stage.output void
 *
 * @stage.name view.render.after
 * @stage.description after view rendered
 * @stage.input IRender &$render, string $viewRendered
 * @stage.output string $viewRendered
 *
 * @package tratabor\interfaces\systems\views
 * @author Funcraft <me@funcraft.ru>
 */
interface IViewRender extends IItem
{
    const SUBJECT = 'view';

    const STAGE__VIEW_INIT = 'view.init';
    const STAGE__VIEW_AFTER = 'view.after';

    const STAGE__VIEW_PATH = 'view.path';
    const STAGE__VIEW_BEFORE_RENDER = 'view.render.before';
    const STAGE__VIEW_AFTER_RENDER = 'view.render.after';

    /**
     * @param $view
     * @param $data
     *
     * @return string
     */
    public function render($view, $data): string;

    /**
     * @return string
     */
    public function getViewName(): string;

    /**
     * @return array
     */
    public function getViewData(): array;

    /**
     * @return string
     */
    public function getViewBasePath(): string;
}
