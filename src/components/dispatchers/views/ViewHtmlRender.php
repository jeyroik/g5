<?php
namespace tratabor\components\dispatchers\views;

use tratabor\components\systems\states\machines\plugins\PluginInitContextSuccess;
use tratabor\components\systems\views\ViewRender;
use tratabor\interfaces\systems\IContext;
use tratabor\interfaces\systems\IState;
use tratabor\interfaces\systems\states\IStateDispatcher;
use tratabor\interfaces\systems\states\IStateMachine;

/**
 * Class ViewHtmlRender
 *
 * @package tratabor\components\dispatchers\views
 * @author Funcraft <me@funcraft.ru>
 */
class ViewHtmlRender implements IStateDispatcher
{
    /**
     * @param IState $currentState
     * @param IContext $context
     *
     * @return IContext
     */
    public function __invoke(IState $currentState, IContext $context): IContext
    {
        $this->render($context);
        $context->updateItem(PluginInitContextSuccess::CONTEXT__SUCCESS, true);

        return $context;
    }

    /**
     * @param IContext $context
     *
     * @return $this
     * @throws \Exception
     */
    protected function render($context)
    {
        $viewRender = new ViewRender();
        $content = '';

        try {
            $views = $context->readItem('html')->getValue();
        } catch (\Exception $e) {
            $views = [];
        }

        foreach ($views as $view) {
            $content .= $view;
        }

        echo $viewRender->render('index/index', ['content' => $content]);

        return $this;
    }
}
