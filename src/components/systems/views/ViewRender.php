<?php
namespace tratabor\components\systems\views;

use tratabor\interfaces\systems\views\IViewRender;

/**
 * Class ViewRender
 *
 * @package tratabor\components\systems\views
 * @author Funcraft <me@funcraft.ru>
 */
class ViewRender implements IViewRender
{
    protected $viewName = '';
    protected $viewBasePath = '';
    protected $viewData = [];

    /**
     * ViewRender constructor.
     */
    public function __construct()
    {
        $this->viewBasePath = getenv('G5__VIEW__PATH') ?: G5__ROOT_PATH . '/resources/views/';
    }

    /**
     * @param $viewName
     * @param $data
     *
     * @return string
     * @throws \Exception
     */
    public function render($viewName, $data): string
    {
        $this->viewName = $viewName;
        $this->viewData = $data;

        $viewFullPath = $this->viewBasePath . $this->viewName . '.php';

        if (is_file($viewFullPath)) {
            ob_start();

            extract($this->viewData);
            require $viewFullPath;
            $viewContent = ob_get_contents();

            ob_end_clean();

            return $viewContent;
        } else {
            throw new \Exception('Missed or restricted view file path "' . $viewFullPath . '".');
        }

    }
}
