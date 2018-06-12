<?php

use tratabor\interfaces\systems\states as IStates;
use tratabor\components\systems\states as CStates;
use tratabor\interfaces\systems\plugins as ISystemPlugins;

return [
    IStates\IStateFactory::class => CStates\StateFactory::class,
    IStates\dispatchers\IDispatchersFactory::class => CStates\dispatchers\DispatcherFactory::class,
    ISystemPlugins\IPluginRepository::class => \tratabor\components\systems\plugins\PluginRepository::class
];
