<?php

use jeyroik\extas\components\systems\extensions\ExtensionRepository as Config;

use jeyroik\extas\interfaces\systems\IContext;
use jeyroik\extas\components\systems\states\extensions\ExtensionContextOnFailure;
use jeyroik\extas\components\systems\states\StatesRoute;
use jeyroik\extas\interfaces\systems\states\IStateMachine;
use jeyroik\extas\components\systems\states\machines\extensions\ExtensionContextErrors;
use jeyroik\extas\interfaces\systems as ISystems;
use jeyroik\extas\components\systems\states\plugins as StatesPlugins;
use tratabor\components\extensions\basics\boards\BoardExtensionContextFreeBoard;
use tratabor\components\extensions\basics\worlds\WorldContextExtension;
use jeyroik\extas\components\systems\states\plugins\ExtensionMaxTry;
use jeyroik\extas\interfaces\systems\IState;

return [
    Config::CONFIG__METHODS => [
        IStateMachine::class => [
            'from' => StatesRoute::class,
            'to' => StatesRoute::class,
            'getRoute' => StatesRoute::class,
            'setRoute' => StatesRoute::class,
            'getCurrentFrom' => StatesRoute::class,
            'getCurrentTo' => StatesRoute::class
        ],
        IContext::class => [
            /**
             * Default extensions
             */
            'setSuccess' => ExtensionContextOnFailure::class,
            'setFail' => ExtensionContextOnFailure::class,
            'addError' => ExtensionContextErrors::class,

            /**
             * G5 extensions
             */
            'getFreeBoard' => BoardExtensionContextFreeBoard::class,
            'setFreeBoard' => BoardExtensionContextFreeBoard::class,

            'getWorld' => WorldContextExtension::class,
            'isWorldExist' => WorldContextExtension::class,
            'findWorld' => WorldContextExtension::class,
            'createWorld' => WorldContextExtension::class
        ],
        IState::class => [
            'getMaxTry' => ExtensionMaxTry::class,
            'getOnTerminate' => ExtensionMaxTry::class,
            'incTry' => ExtensionMaxTry::class,
            'getTriesCount' => ExtensionMaxTry::class
        ]
    ],

    Config::CONFIG__IMPLEMENTATIONS => [
        ExtensionContextOnFailure::class => ExtensionContextOnFailure::class,
        StatesRoute::class => [
            Config::CONFIG__CLASS => StatesRoute::class,
            Config::CONFIG__ARGUMENTS => [
                ISystems\IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID => ISystems\states\IStatesRoute::class,
                ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
                    [
                        ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginRouteFromStart::class,
                        ISystems\IPlugin::FIELD__VERSION => '1.0',
                        ISystems\IPlugin::FIELD__STAGE => ISystems\states\IStatesRoute::STAGE__FROM
                    ],
                    [
                        ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginRouteToPath::class,
                        ISystems\IPlugin::FIELD__VERSION => '1.0',
                        ISystems\IPlugin::FIELD__STAGE => ISystems\states\IStatesRoute::STAGE__TO
                    ]
                ]
            ]
        ],
        ExtensionContextErrors::class => ExtensionContextErrors::class,
        BoardExtensionContextFreeBoard::class => BoardExtensionContextFreeBoard::class
    ]
];
