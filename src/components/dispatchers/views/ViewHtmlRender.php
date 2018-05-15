<?php
namespace tratabor\components\dispatchers\views;

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
        $this->render('', $context);
        $context->updateItem(IStateMachine::CONTEXT__SUCCESS, false);

        return $context;
    }

    /**
     * @param string $view
     * @param IContext $context
     *
     * @return $this
     * @throws \Exception
     */
    protected function render($view = '', $context)
    {
        $view = $view ?: 'index/index';
        $basePath = getenv('G5__VIEWS__PATH') ?: G5__ROOT_PATH . '/resources/views/';

        if (is_file($basePath . $view)) {
            ob_start();
            $content = '<pre>' . print_r($context, true) . '</pre>';
            require $basePath . $view;
            $viewContent = ob_get_contents();
            ob_end_clean();

            echo $viewContent;
        } else {
            throw new \Exception('Missed or restricted view file path "' . $basePath . $view . '".');
        }

        return $this;
    }
}
