<?php

use jeyroik\extas\interfaces\systems\states as IStates;
use jeyroik\extas\components\systems\states as CStates;
use jeyroik\extas\interfaces\systems\plugins as ISystemPlugins;

return [
    IStates\IStateFactory::class => CStates\StateFactory::class,
    IStates\dispatchers\IDispatchersFactory::class => CStates\dispatchers\DispatcherFactory::class,
    ISystemPlugins\IPluginRepository::class => \jeyroik\extas\components\systems\plugins\PluginRepository::class
];
