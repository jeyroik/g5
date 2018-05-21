<?php
namespace tratabor\components\basics\boards;

use tratabor\components\basics\BasicBoard;
use tratabor\components\systems\repositories\RepositoryJson;

/**
 * Class BoardRepository
 *
 * @package tratabor\components\basics\boards
 * @author Funcraft <me@funcraft.ru>
 */
class BoardRepository extends RepositoryJson
{
    protected $dsn = G5__ROOT_PATH . '/runtime/boards.json';
    protected $itemClass = BasicBoard::class;
}
