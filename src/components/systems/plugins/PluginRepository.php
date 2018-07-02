<?php
namespace tratabor\components\systems\plugins;

use jeyroik\extas\components\systems\Plugin;
use jeyroik\extas\interfaces\systems\plugins\IPluginRepository;
use tratabor\components\systems\repositories\RepositoryMongo;

/**
 * Class PluginRepository
 *
 * @package tratabor\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginRepository extends RepositoryMongo implements IPluginRepository
{
    protected $collectionName = 'g5__packages__plugins';
    protected $itemClass = Plugin::class;
}
