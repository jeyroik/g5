<?php
namespace tratabor\components\dispatchers\views;

use jeyroik\extas\components\dispatchers\DispatcherAbstract;
use jeyroik\extas\interfaces\systems\contexts\IContextOnFailure;
use tratabor\components\systems\views\ViewRender;
use jeyroik\extas\interfaces\systems\IContext;
use tratabor\interfaces\systems\contexts\IContextRender;

/**
 * Class ViewHtmlRender
 *
 * @package tratabor\components\dispatchers\views
 * @author Funcraft <me@funcraft.ru>
 */
class ViewHtmlRender extends DispatcherAbstract
{
    protected $requireInterfaces = [
        IContextOnFailure::class,
        IContextRender::class
    ];

    /**
     * @param IContext|IContextOnFailure $context
     *
     * @return IContext
     */
    protected function dispatch(IContext $context): IContext
    {
        $this->render($context);
        $context->setSuccess();

        return $context;
    }

    /**
     * @param IContext|IContextRender $context
     *
     * @return $this
     * @throws \Exception
     */
    protected function render($context)
    {
        $viewRender = new ViewRender();
        $content = '';
        $views = $context->getViews();

        foreach ($views as $view) {
            $content .= $view;
        }

        echo $viewRender->render('index/index', ['content' => $content]);

        return $this;
    }
}
