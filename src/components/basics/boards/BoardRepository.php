<?php
namespace tratabor\components\basics\boards;

use tratabor\components\basics\BasicBoard;
use tratabor\components\systems\repositories\RepositoryMongo;

/**
 * Class BoardRepository
 *
 * @package tratabor\components\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardRepository extends RepositoryMongo
{
    protected $itemClass = BasicBoard::class;
    protected $collectionName = 'g5__boards';
    protected $name = 'board';
}
