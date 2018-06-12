<?php

use tratabor\interfaces\systems\states\IStateFactory as State;
use tratabor\interfaces\systems\states\IStateMachine as Machine;
use tratabor\interfaces\systems\states\machines\IMachineConfig;
use tratabor\components\systems\states\machines\plugins\PluginInitConfigStatePlugins as StatePlugins;
use tratabor\interfaces\systems as ISystems;
use tratabor\components\systems\states\plugins as StatesPlugins;
use tratabor\components\systems\states\machines\plugins as MachinePlugins;

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

    MachinePlugins\PluginInitMachineStatesRoute::ROUTE__CONFIG => [
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
    ],

    ISystems\IPluginsAcceptable::FIELD__PLUGINS_SUBJECT_ID => 'default_machine',
    ISystems\IPluginsAcceptable::FIELD__PLUGINS => [
        /**
         * Plugins for the current machine.
         */
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginInitMachineStatesRoute::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__INIT_STATE_MACHINE
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginInitContextSuccess::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__INIT_CONTEXT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginInitContextErrors::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__INIT_CONTEXT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunCycle::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunExistingState::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunStart::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => MachinePlugins\PluginBeforeStateRunTheEnd::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_RUN
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginStateResultOnFailure::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__STATE_RESULT
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginBeforeStateBuildGuaranteeStateId::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_BUILD
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginBeforeStateBuildErrorState::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__BEFORE_STATE_BUILD
        ],
        [
            ISystems\IPlugin::FIELD__CLASS => StatesPlugins\PluginIsStateValidMaxTry::class,
            ISystems\IPlugin::FIELD__VERSION => '1.0',
            ISystems\IPlugin::FIELD__STAGE => Machine::STAGE__IS_STATE_VALID
        ]
    ],

    IMachineConfig::FIELD__STATES => [
        'app:run' => [
            State::STATE__ID => 'app:run',
            State::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\DispatcherSuccess::class
            ],
            State::STATE__ON_SUCCESS => 'world:exists',
            State::STATE__ON_FAILURE => 'app:terminate',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],

        'test:to_state' => [
            State::STATE__ID => 'test:to_state',
            State::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\DispatcherSuccess::class
            ],
            State::STATE__ON_SUCCESS => '',
            State::STATE__ON_FAILURE => '',
            State::STATE__ON_TERMINATE => '',
            'plugins' => [

            ]
        ],
        'app:terminate' => [
            State::STATE__ID => 'app:terminate',
            State::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                function ($currentState, $context) {
                    /**
                     * @var $currentState \tratabor\interfaces\systems\IState
                     */
                    echo 'App termination at ' . $currentState->getId() . ' ...<br/><pre>';
                    print_r($context);
                    echo '</pre>';

                    return $context;
                }
            ],
            State::STATE__ON_SUCCESS => '',
            State::STATE__ON_FAILURE => '',
            State::STATE__ON_TERMINATE => '',
        ],
        'app:failure' => [
            State::STATE__ID => 'app:failure',
            State::STATE__MAX_TRY => 1,
            State::STATE__DISPATCHERS => [
                function ($currentState, $context) {
                    /**
                     * @var $currentState \tratabor\interfaces\systems\IState
                     */
                    echo 'App failure on "' . $currentState->getId() . '"...<br/><pre>';
                    print_r($context);
                    echo '</pre>';

                    return $context;
                }
            ],
            State::STATE__ON_SUCCESS => '',
            State::STATE__ON_FAILURE => '',
            State::STATE__ON_TERMINATE => '',
        ],
        'world:exists' => [
            State::STATE__ID => 'world:exists',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\worlds\WorldExists::class
            ],
            State::STATE__ON_SUCCESS => 'user:is_authorized',
            State::STATE__ON_FAILURE => 'world:create',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'user:is_authorized' => [
            State::STATE__ID => 'user:is_authorized',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\users\UserAuthorized::class
            ],
            State::STATE__ON_SUCCESS => 'user:profile_exists',
            State::STATE__ON_FAILURE => 'world:info_render',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'user:profile_exists' => [
            State::STATE__ID => 'user:profile_exists',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\DispatcherSuccess::class
            ],
            State::STATE__ON_SUCCESS => 'profile:hero_exists',
            State::STATE__ON_FAILURE => 'profile:create',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'profile:hero_exists' => [
            State::STATE__ID => 'profile:hero_exists',
            State::STATE__MAX_TRY => 2,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\creatures\CreatureHeroExists::class
            ],
            State::STATE__ON_SUCCESS => 'hero:board_check',
            State::STATE__ON_FAILURE => 'hero:create',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:create' => [
            State::STATE__ID => 'hero:create',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\creatures\CreatureHeroCreate::class
            ],
            State::STATE__ON_SUCCESS => 'profile:hero_exists',
            State::STATE__ON_FAILURE => 'app:terminate',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:board_check' => [
            State::STATE__ID => 'hero:board_check',
            State::STATE__MAX_TRY => 3,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardCheck::class
            ],
            State::STATE__ON_SUCCESS => 'hero:route_exists',
            State::STATE__ON_FAILURE => 'board:free_exists',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:route_exists' => [
            State::STATE__ID => 'hero:route_exists',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\DispatcherSuccess::class
            ],
            State::STATE__ON_SUCCESS => 'request:debug_exists',
            State::STATE__ON_FAILURE => 'route:create',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'request:debug_exists' => [
            State::STATE__ID => 'request::debug_exists',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\DispatcherFail::class
            ],
            State::STATE__ON_SUCCESS => 'response:json_render',
            State::STATE__ON_FAILURE => 'board:render',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:render' => [
            State::STATE__ID => 'board:render',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardRender::class
            ],
            State::STATE__ON_SUCCESS => 'board:c_panel_render',
            State::STATE__ON_FAILURE => '',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:c_panel_render' => [
            State::STATE__ID => 'board:c_panel_render',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\DispatcherSuccess::class
            ],
            State::STATE__ON_SUCCESS => 'response:html_render',
            State::STATE__ON_FAILURE => '',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'response:html_render' => [
            State::STATE__ID => 'response:html_render',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\views\ViewHtmlRender::class
            ],
            State::STATE__ON_SUCCESS => '',
            State::STATE__ON_FAILURE => '',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:free_exists' => [
            State::STATE__ID => 'board:free_exists',
            State::STATE__MAX_TRY => 2,
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardFreeExists::class
            ],
            State::STATE__ON_SUCCESS => 'board:hero_attach',
            State::STATE__ON_FAILURE => 'board:create',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:hero_attach' => [
            State::STATE__ID => 'board:hero_attach',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardHeroAttach::class
            ],
            State::STATE__ON_SUCCESS => 'hero:board_check',
            State::STATE__ON_FAILURE => 'app:failure',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:create' => [
            State::STATE__ID => 'board:create',
            State::STATE__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardCreate::class
            ],
            State::STATE__ON_SUCCESS => 'hero:board_check',
            State::STATE__ON_FAILURE => 'app:terminate',
            State::STATE__ON_TERMINATE => 'app:terminate',
        ],
    ]
];
