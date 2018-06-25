<?php
namespace tratabor\components\basics;

use tratabor\components\systems\views\ViewRender;
use tratabor\interfaces\basics\cells\ICellSnag;

/**
 * Class BasicSnag
 *
 * @package tratabor\components\basics
 * @author Funcraft <me@funcraft.ru>
 */
class BasicSnag extends Basic implements ICellSnag
{
    /**
     * @return string
     */
    public function getAvatar(): string
    {
        return $this->data['avatar'] ?? '';
    }

    /**
     * @param $creature
     *
     * @return mixed
     */
    public function applyTo($creature)
    {
        return $creature;
    }

    /**
     * @return bool
     */
    public function isCanBePassed(): bool
    {
        return $this->data['is_can_be_passed'] ?? true;
    }

    /**
     * @param string $viewPath
     *
     * @return string
     */
    public function render($viewPath): string
    {
        $viewRender = new ViewRender();

        return $viewRender->render($viewPath, ['snag' => $this]);
    }
}
