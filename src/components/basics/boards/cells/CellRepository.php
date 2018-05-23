<?php
namespace tratabor\components\basics\boards\cells;

use tratabor\components\basics\boards\BoardCell;
use tratabor\components\systems\repositories\RepositoryPhp;

/**
 * Class CellRepository
 *
 * @package tratabor\components\basics\boards\cells
 * @author Funcraft <me@funcraft.ru>
 */
class CellRepository extends RepositoryPhp
{
    protected $itemClass = BoardCell::class;
}
