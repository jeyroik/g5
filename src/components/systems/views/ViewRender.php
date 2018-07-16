<?php
namespace tratabor\components\systems\views;

use jeyroik\extas\components\systems\Item;
use tratabor\interfaces\systems\views\IViewRender;

/**
 * Class ViewRender
 *
 * @package tratabor\components\systems\views
 * @author Funcraft <me@funcraft.ru>
 */
class ViewRender extends Item implements IViewRender
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

        parent::__construct();
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

        foreach ($this->getPluginsByStage(static::STAGE__VIEW_PATH) as $plugin) {
            $viewFullPath = $plugin($this, $viewFullPath);
        }

        if (is_file($viewFullPath)) {

            foreach ($this->getPluginsByStage(static::STAGE__VIEW_BEFORE_RENDER) as $plugin) {
                $plugin($this, $viewFullPath);
            }

            ob_start();
            extract($this->viewData);
            require $viewFullPath;
            $viewContent = ob_get_contents();
            ob_end_clean();

            foreach ($this->getPluginsByStage(static::STAGE__VIEW_AFTER_RENDER) as $plugin) {
                $viewContent = $plugin($this, $viewContent);
            }

            return $viewContent;
        } else {
            throw new \Exception('Missed or restricted view file path "' . $viewFullPath . '".');
        }
    }

    /**
     * @return string
     */
    public function getViewName(): string
    {
        return $this->viewName;
    }

    /**
     * @return array
     */
    public function getViewData(): array
    {
        return $this->viewData;
    }

    /**
     * @return string
     */
    public function getViewBasePath(): string
    {
        return $this->viewBasePath;
    }

    /**
     * @return string
     */
    protected function getSubjectForExtension(): string
    {
        return static::SUBJECT;
    }
}
