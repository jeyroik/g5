<?php

use tratabor\interfaces\systems\states as IStates;
use tratabor\components\systems\states as CStates;

return [
    IStates\IStateFactory::class => CStates\StateFactory::class,
    IStates\dispatchers\IDispatchersFactory::class => CStates\dispatchers\DispatcherFactory::class
];
