<?php
namespace tratabor\components\basics\boards\cells;

use tratabor\components\basics\boards\BoardCell;
use jeyroik\extas\components\systems\repositories\RepositoryMongo;

/**
 * Class CellRepository
 *
 * @package tratabor\components\basics\boards\cells
 * @author Funcraft <me@funcraft.ru>
 */
class CellRepository extends RepositoryMongo
{
    protected $itemClass = BoardCell::class;
    protected $collectionName = 'g5__board__cells';
}
