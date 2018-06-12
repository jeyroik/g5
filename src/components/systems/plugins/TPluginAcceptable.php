<?php
namespace tratabor\components\systems\plugins;

use tratabor\components\systems\Plugin;
use tratabor\components\systems\SystemContainer;
use tratabor\interfaces\systems\IPlugin;
use tratabor\interfaces\systems\IPluginsAcceptable;
use tratabor\interfaces\systems\plugins\IPluginRepository;

/**
 * Trait TPluginAcceptable
 *
 * @package tratabor\components\systems\plugins
 * @author Funcraft <me@funcraft.ru>
 */
trait TPluginAcceptable
{
    /**
     * @param mixed $subject
     * @param string $stage
     * @param IPlugin $plugin
     *
     * @return bool
     */
    public function registerPlugin($subject, $stage, IPlugin $plugin)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        $pluginRepo::addPluginForStage(
            $subject,
            $stage,
            $plugin->getClass()
        );

        return true;
    }

    /**
     * @param $stage
     *
     * @return \Generator|IPlugin
     */
    public function getPluginsByStage($stage)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);

        foreach ($pluginRepo::getPluginsForStage($this, $stage) as $plugin) {
            yield $plugin;
        }
    }

    /**
     * @param array $source
     *
     * @return $this
     */
    protected function registerPlugins($source)
    {
        /**
         * @var $pluginRepo IPluginRepository
         */
        $pluginRepo = SystemContainer::getItem(IPluginRepository::class);
        $plugins = $source[IPluginsAcceptable::FIELD__PLUGINS] ?? $source;

        $pluginSubjectId = $source[IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID] ?? static::class;
        foreach ($plugins as $pluginConfig) {
            $plugin = new Plugin($pluginConfig);
            $pluginRepo::addPluginForStage($pluginSubjectId, $plugin->getStage(), $plugin->getClass());
        }

        return $this;
    }
}
