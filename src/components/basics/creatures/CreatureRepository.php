<?php
namespace tratabor\components\basics\creatures;

use tratabor\components\basics\BasicCreature;
use tratabor\components\systems\repositories\RepositoryJson;

/**
 * Class CreatureRepository
 *
 * @package tratabor\components\basics\creatures
 * @author Funcraft <me@funcraft.ru>
 */
class CreatureRepository extends RepositoryJson
{
    protected $dsn = G5__ROOT_PATH . '/runtime/creatures.json';
    protected $itemClass = BasicCreature::class;
}
