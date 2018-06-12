<?php
namespace tratabor\components\basics\worlds;

use tratabor\components\basics\BasicWorld;
use tratabor\components\systems\repositories\RepositoryMongo;

/**
 * Class WorldRepository
 *
 * @package tratabor\components\basics\worlds
 * @author Funcraft <me@funcraft.ru>
 */
class WorldRepository extends RepositoryMongo
{
    protected $itemClass = BasicWorld::class;
    protected $collectionName = 'g5__worlds';
}
