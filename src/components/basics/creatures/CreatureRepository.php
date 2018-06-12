<?php
namespace tratabor\components\basics\creatures;

use tratabor\components\basics\BasicCreature;
use tratabor\components\systems\repositories\RepositoryMongo;

/**
 * Class CreatureRepository
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureRepository extends RepositoryMongo
{
    protected $itemClass = BasicCreature::class;
    protected $collectionName = 'g5__creatures';
}
