<?php
namespace tratabor\interfaces\basics\creatures;

use tratabor\interfaces\basics\ICell;
use tratabor\interfaces\systems\IItem;

/**
 * Interface ICreatureRoute
 *
 * @package tratabor\interfaces\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
interface ICreatureRoute extends IItem
{
    /**
     * @param ICell $cell
     *
     * @return mixed
     */
    public function addStep(ICell $cell);

    /**
     * @return ICell|null
     */
    public function getCurrentPosition();
}
