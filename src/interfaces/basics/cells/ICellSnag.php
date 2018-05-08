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
    public function isCanBePassed(): bool;
    public function applyTo($creature);
}
