<?php
namespace tratabor\interfaces\basics\cells;

use tratabor\interfaces\systems\IItem;

/**
 * Interface ICellSnag
 *
 * @package tratabor\interfaces\basics\cells
 * @author Funcraft <me@funcraft.ru>
 */
interface ICellSnag extends IItem
{
    /**
     * @return string
     */
    public function getAvatar(): string;

    /**
     * @return bool
     */
    public function isCanBePassed(): bool;

    /**
     * @param $creature
     *
     * @return mixed
     */
    public function applyTo($creature);

    /**
     * @param string $viewPath
     *
     * @return string
     */
    public function render($viewPath): string;
}
