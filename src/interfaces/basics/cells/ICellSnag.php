<?php
namespace tratabor\interfaces\basics\cells;

use jeyroik\extas\interfaces\systems\IItem;

/**
 * Interface ICellSnag
 *
 * @stage.expand.type ICellSnag
 * @stage.expand.name tratabor\interfaces\basics\cells\ICellSnag
 *
 * @stage.name cell.snag.init
 * @stage.description Cell snag initialization finish
 * @stage.input ICellSnag $cellSnag
 * @stage.output void
 *
 * @stage.name cell.snag.after
 * @stage.description Cell snag destructing
 * @stage.input ICellSnag $cellSnag
 * @stage.output void
 *
 * @package tratabor\interfaces\basics\cells
 * @author Funcraft <me@funcraft.ru>
 */
interface ICellSnag extends IItem
{
    const SUBJECT = 'cell.snag';

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
