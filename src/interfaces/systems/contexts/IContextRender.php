<?php
namespace tratabor\interfaces\systems\contexts;

use jeyroik\extas\interfaces\systems\IContext;

/**
 * Interface IContextRender
 *
 * @package tratabor\interfaces\systems\contexts
 * @author Funcraft <me@funcraft.ru>
 */
interface IContextRender
{
    const CONTEXT_ITEM__VIEWS = 'views';

    /**
     * @param $view
     * @param IContext|null $context
     *
     * @return bool
     */
    public function addView($view, IContext &$context = null): bool;

    /**
     * @param IContext|null $context
     *
     * @return array
     */
    public function getViews(IContext &$context = null);

    /**
     * @param $views
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setViews($views, IContext &$context = null);
}

