<?php
namespace tratabor\interfaces\systems\views;

/**
 * Interface IViewRender
 *
 * @package tratabor\interfaces\systems\views
 * @author Funcraft <me@funcraft.ru>
 */
interface IViewRender
{
    /**
     * @param $view
     * @param $data
     *
     * @return string
     */
    public function render($view, $data): string;
}
