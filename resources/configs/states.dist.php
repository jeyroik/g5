<?php

use jeyroik\extas\interfaces\systems\states\IStateFactory as State;
use jeyroik\extas\interfaces\systems\states\IStateMachine as Machine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;
use jeyroik\extas\components\systems\states\machines\plugins\PluginInitConfigStatePlugins as StatePlugins;
use jeyroik\extas\interfaces\systems as ISystems;
use jeyroik\extas\components\systems\states\plugins as StatesPlugins;
use jeyroik\extas\components\systems\states\machines\plugins as MachinePlugins;
use jeyroik\extas\components\systems\states\plugins\ExtensionMaxTry as EMaxTry;
use jeyroik\extas\components\systems\states\plugins\PluginStateRunNextOnFailure as POnFail;

/**
 * README
 *
 * Plugin definition:
 * [
 *      ISystems\IPlugin::FIELD__CLASS => <full class name>,
 *      ISystems\IPlugin::FIELD__VERSION => '1.0', // or any other version
 *      ISystems\IPlugin::FIELD__STAGE => <stage name>
 * ]
 */

return [
    Machine::MACHINE__CONFIG => [
        IMachineConfig::FIELD__VERSION  => '1.0',
        IMachineConfig::FIELD__ALIAS => 'primary machine',
        IMachineConfig::FIELD__START_STATE => 'app:run',
        IMachineConfig::FIELD__END_STATE => 'app:terminate',

        ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
            /**
             * Plugins for the current machine config.
             * [
             *      ISystems\IPlugin::FIELD__CLASS => <full class name>,
             *      ISystems\IPlugin::FIELD__VERSION => '1.0', // or any other version
             *      ISystems\IPlugin::FIELD__STAGE => <stage name>
             * ]
             */
        ],

        StatePlugins::MACHINE__STATE_PLUGINS => [
            /**
             * Plugins for each state.
             * Current option is ignoring if state has own plugins definition.
             */
        ]
    ],

    ISystems\IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID => 'default_machine',
    ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
        /**
         * Plugins for the current machine.
         */
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginInitContextSuccess::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__MACHINE_INIT_CONTEXT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginStateRunBeforeCycle::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginStateRunBeforeExistingState::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginStateRunBeforeStart::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginStateRunBeforeTheEnd::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateBuildBeforeStatesRoute::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_BUILD_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateRunNextOnFailure::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_NEXT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateRunAfterOnFailure::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_AFTER
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateBuildBeforeGuaranteeStateId::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_BUILD_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateBuildBeforeError::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_BUILD_BEFORE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateRunValidMaxTry::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RUN_IS_VALID
        ]
    ],

    IMachineConfig::FIELD__STATES => [
        'app:run' => [
            State::STATE__ID => 'app:run',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'world:exists',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'app:terminate' => [
            State::STATE__ID => 'app:terminate',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                function ($currentState, $context) {
                    /**
                     * @var $currentState \jeyroik\extas\interfaces\systems\IState
                     */
                    echo 'App termination at ' . $currentState->getId() . ' ...<br/><pre>';
                    print_r($context);
                    echo '</pre>';

                    return $context;
                }
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => '',
        ],
        'app:failure' => [
            State::STATE__ID => 'app:failure',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                function ($currentState, $context) {
                    /**
                     * @var $currentState \jeyroik\extas\interfaces\systems\IState
                     */
                    echo 'App failure on "' . $currentState->getId() . '"...<br/><pre>';
                    print_r($context);
                    echo '</pre>';

                    return $context;
                }
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => '',
        ],
        'world:exists' => [
            State::STATE__ID => 'world:exists',
            EMaxTry::STATE__MAX_TRY => 2,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\worlds\WorldExists::class
            ],
            POnFail::STATE__ON_SUCCESS => 'user:is_authorized',
            POnFail::STATE__ON_FAILURE => 'world:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'world:create' => [
            State::STATE__ID => 'world:create',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\worlds\WorldCreate::class
            ],
            POnFail::STATE__ON_SUCCESS => 'world:exists',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'user:is_authorized' => [
            State::STATE__ID => 'user:is_authorized',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\users\UserAuthorized::class
            ],
            POnFail::STATE__ON_SUCCESS => 'user:profile_exists',
            POnFail::STATE__ON_FAILURE => 'world:info_render',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'user:profile_exists' => [
            State::STATE__ID => 'user:profile_exists',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'profile:hero_exists',
            POnFail::STATE__ON_FAILURE => 'profile:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'profile:hero_exists' => [
            State::STATE__ID => 'profile:hero_exists',
            EMaxTry::STATE__MAX_TRY => 2,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\creatures\CreatureHeroExists::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:board_check',
            POnFail::STATE__ON_FAILURE => 'hero:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:create' => [
            State::STATE__ID => 'hero:create',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\creatures\CreatureHeroCreate::class
            ],
            POnFail::STATE__ON_SUCCESS => 'profile:hero_exists',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:board_check' => [
            State::STATE__ID => 'hero:board_check',
            EMaxTry::STATE__MAX_TRY => 3,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardCheck::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:route_exists',
            POnFail::STATE__ON_FAILURE => 'board:free_exists',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:route_exists' => [
            State::STATE__ID => 'hero:route_exists',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'request:debug_exists',
            POnFail::STATE__ON_FAILURE => 'route:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'request:debug_exists' => [
            State::STATE__ID => 'request::debug_exists',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherFail::class
            ],
            POnFail::STATE__ON_SUCCESS => 'response:json_render',
            POnFail::STATE__ON_FAILURE => 'board:render',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:render' => [
            State::STATE__ID => 'board:render',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardRender::class
            ],
            POnFail::STATE__ON_SUCCESS => 'board:c_panel_render',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:c_panel_render' => [
            State::STATE__ID => 'board:c_panel_render',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'response:html_render',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'response:html_render' => [
            State::STATE__ID => 'response:html_render',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\views\ViewHtmlRender::class
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:free_exists' => [
            State::STATE__ID => 'board:free_exists',
            EMaxTry::STATE__MAX_TRY => 2,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardFreeExists::class
            ],
            POnFail::STATE__ON_SUCCESS => 'board:hero_attach',
            POnFail::STATE__ON_FAILURE => 'board:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:hero_attach' => [
            State::STATE__ID => 'board:hero_attach',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardHeroAttach::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:board_check',
            POnFail::STATE__ON_FAILURE => 'app:failure',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:create' => [
            State::STATE__ID => 'board:create',
            EMaxTry::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardCreate::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:board_check',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
    ]
];
