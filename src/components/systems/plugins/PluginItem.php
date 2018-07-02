<?php
namespace tratabor\components\systems\plugins;

use jeyroik\extas\components\systems\Item;
use jeyroik\extas\components\systems\plugins\crawlers\CrawlerPackage;
use jeyroik\extas\interfaces\systems\IItem;
use jeyroik\extas\interfaces\systems\plugins\crawlers\ICrawlerPackage;

/**
 * Class PluginItem
 *
 * @package tratabor\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
class PluginItem extends Item implements IItem, ICrawlerPackage
{
    const CONFIG__ID = 'id';
    const CONFIG__CREATED_AT = 'created_at';
    const CONFIG__UPDATED_AT = 'updated_at';
    const CONFIG__PACKAGE = 'package';
    const CONFIG__PACKAGE_VERSION = 'package_version';
    const CONFIG__PACKAGE_NAME = 'package_name';
    const CONFIG__USAGES_COUNT = 'usages_count';

    protected $item = [];

    /**
     * PluginItem constructor.
     *
     * @param array $itemConfig
     */
    public function __construct($itemConfig = [])
    {
        $this->initItem($itemConfig);
        parent::__construct('plugin', 'plugin_' . time());
    }

    /**
     * @return string
     */
    public function getInfoHash(): string
    {
        return sha1(json_encode($this->item));
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return [
            CrawlerPackage::CONFIG__NAME => $this->getName(),
            CrawlerPackage::CONFIG__DESCRIPTION => $this->getDescription(),
            CrawlerPackage::CONFIG__REQUIRE => $this->getRequire(),
            CrawlerPackage::CONFIG__PRODUCE => $this->getProduce(),

            static::CONFIG__CREATED_AT => $this->getCreatedAt(),
            static::CONFIG__UPDATED_AT => $this->getUpdatedAt(),
            static::CONFIG__PACKAGE => $this->getPackage(),
            static::CONFIG__USAGES_COUNT => $this->getUsagesCount()
        ];
    }

    /**
     * @param string $format
     *
     * @return false|int|mixed|string
     */
    public function getUpdatedAt($format = '')
    {
        return isset($this->item[static::CONFIG__UPDATED_AT])
            ? (
            $format
                ? date($format, $this->item[static::CONFIG__UPDATED_AT])
                : $this->item[static::CONFIG__UPDATED_AT]
            )
            : 0;
    }

    /**
     * @param string $format
     *
     * @return false|int|mixed|string
     */
    public function getCreatedAt($format = '')
    {
        return isset($this->item[static::CONFIG__CREATED_AT])
            ? (
                $format
                    ? date($format, $this->item[static::CONFIG__CREATED_AT])
                    : $this->item[static::CONFIG__CREATED_AT]
            )
            : 0;
    }

    /**
     * @param string $field
     *
     * @return array|mixed|null
     */
    public function getPackage($field = '')
    {
        if (isset($this->item[static::CONFIG__PACKAGE])) {
            return $field
                ? ($this->item[static::CONFIG__PACKAGE][$field] ?? null)
                : $this->item[static::CONFIG__PACKAGE];
        }

        return [];
    }

    /**
     * @return int|mixed
     */
    public function getUsagesCount()
    {
        return $this->item[static::CONFIG__USAGES_COUNT] ?? 0;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->item[CrawlerPackage::CONFIG__NAME] ?? '';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->item[CrawlerPackage::CONFIG__DESCRIPTION] ?? '';
    }

    /**
     * @param string $name
     *
     * @return array|mixed
     */
    public function getRequire($name = '')
    {
        if (isset($this->item[CrawlerPackage::CONFIG__REQUIRE])) {
            return $name
                ? ($this->item[CrawlerPackage::CONFIG__REQUIRE][$name] ?? [])
                : $this->item[CrawlerPackage::CONFIG__REQUIRE];
        }

        return [];
    }

    /**
     * @param string $name
     *
     * @return array|mixed
     */
    public function getProduce($name = '')
    {
        if (isset($this->item[CrawlerPackage::CONFIG__PRODUCE])) {
            return $name
                ? ($this->item[CrawlerPackage::CONFIG__PRODUCE][$name] ?? [])
                : $this->item[CrawlerPackage::CONFIG__PRODUCE];
        }

        return [];
    }

    /**
     * @param $config
     *
     * @return $this
     */
    protected function initItem($config)
    {
        $this->item = $config;

        return $this;
    }
}
