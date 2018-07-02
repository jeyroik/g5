<?php
namespace tratabor\components\systems\plugins;

use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPackage;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;
use tratabor\components\systems\repositories\RepositoryMongo;

/**
 * Class PluginStorage
 *
 * @package tratabor\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginStorage extends RepositoryMongo
{
    protected $collectionName = 'g5__plugins';
    protected $itemClass = PluginItem::class;

    /**
     * @param $item
     *
     * @return mixed
     */
    public function create($item)
    {
        if (is_object($item) && ($item instanceof ICrawlerPackage)) {
            $storageItemConfig = [
                CrawlerPackage::CONFIG__NAME => $item->getName(),
                CrawlerPackage::CONFIG__DESCRIPTION => $item->getDescription(),
                CrawlerPackage::CONFIG__REQUIRE => $item->getRequire(),
                CrawlerPackage::CONFIG__PRODUCE => $item->getProduce(),
                CrawlerPackage::CONFIG__PACKAGE => $item->getPackage(),

                PluginItem::CONFIG__USAGES_COUNT => 0,
                PluginItem::CONFIG__CREATED_AT => time(),
                PluginItem::CONFIG__UPDATED_AT => time()
            ];
            $item = new PluginItem($storageItemConfig);
        }

        return parent::create($item);
    }
}
