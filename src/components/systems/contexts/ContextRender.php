<?php
namespace tratabor\components\systems\extensions;

use jeyroik\extas\components\systems\Extension;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\systems\contexts\IContextRender;

/**
 * Class ContextRender
 *
 * @package tratabor\components\systems\extensions
 * @author Funcraft <me@funcraft.ru>
 */
class ContextRender extends Extension implements IContextRender
{
    public $methods = [
        'addView' => ContextRender::class,
        'getViews' => ContextRender::class
    ];

    public $subject = IContext::SUBJECT;

    /**
     * @param $view
     * @param IContext|null $context
     *
     * @return bool
     */
    public function addView($view, IContext &$context = null): bool
    {
        $views = $this->getViews($context);
        $views[] = $view;
        $this->setViews($views);

        return true;
    }

    /**
     * @param IContext|null $context
     *
     * @return array
     */
    public function getViews(IContext &$context = null)
    {
        $views = $context[static::CONTEXT_ITEM__VIEWS];

        if (empty($views)) {
            $views = [];
            $this->setViews($views);
        }

        return $views;
    }

    /**
     * @param $views
     * @param IContext|null $context
     *
     * @return IContext
     */
    public function setViews($views, IContext &$context = null)
    {
        $context[static::CONTEXT_ITEM__VIEWS] = $views;

        return $context;
    }
}
