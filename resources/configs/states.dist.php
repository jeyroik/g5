<?php

use jeyroik\extas\interfaces\systems\IState as State;
use jeyroik\extas\interfaces\systems\states\IStateMachine as Machine;
use jeyroik\extas\interfaces\systems\states\machines\IMachineConfig;
use jeyroik\extas\components\systems\states\plugins\PluginStateRunNextOnFailure as POnFail;
use jeyroik\extas\components\systems\states\extensions\ExtensionMaxTry as EMaxTry;

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
    ],
    
    IMachineConfig::FIELD__STATES => [
        'app:run' => [
            State::FIELD__ID => 'app:run',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'world:exists',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'app:terminate' => [
            State::FIELD__ID => 'app:terminate',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
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
            State::FIELD__ID => 'app:failure',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
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
            State::FIELD__ID => 'world:exists',
            EMaxTry::STATE__MAX_TRY => 2,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\worlds\WorldExists::class
            ],
            POnFail::STATE__ON_SUCCESS => 'user:is_authorized',
            POnFail::STATE__ON_FAILURE => 'world:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'world:create' => [
            State::FIELD__ID => 'world:create',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\worlds\WorldCreate::class
            ],
            POnFail::STATE__ON_SUCCESS => 'world:exists',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'user:is_authorized' => [
            State::FIELD__ID => 'user:is_authorized',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\users\UserAuthorized::class
            ],
            POnFail::STATE__ON_SUCCESS => 'user:profile_exists',
            POnFail::STATE__ON_FAILURE => 'world:info_render',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'user:profile_exists' => [
            State::FIELD__ID => 'user:profile_exists',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'profile:hero_exists',
            POnFail::STATE__ON_FAILURE => 'profile:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'profile:hero_exists' => [
            State::FIELD__ID => 'profile:hero_exists',
            EMaxTry::STATE__MAX_TRY => 2,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\creatures\CreatureHeroExists::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:board_check',
            POnFail::STATE__ON_FAILURE => 'hero:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:create' => [
            State::FIELD__ID => 'hero:create',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\creatures\CreatureHeroCreate::class
            ],
            POnFail::STATE__ON_SUCCESS => 'profile:hero_exists',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:board_check' => [
            State::FIELD__ID => 'hero:board_check',
            EMaxTry::STATE__MAX_TRY => 3,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardCheck::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:route_exists',
            POnFail::STATE__ON_FAILURE => 'board:free_exists',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'hero:route_exists' => [
            State::FIELD__ID => 'hero:route_exists',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'request:debug_exists',
            POnFail::STATE__ON_FAILURE => 'route:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'request:debug_exists' => [
            State::FIELD__ID => 'request::debug_exists',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherFail::class
            ],
            POnFail::STATE__ON_SUCCESS => 'response:json_render',
            POnFail::STATE__ON_FAILURE => 'board:render',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:render' => [
            State::FIELD__ID => 'board:render',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardRender::class
            ],
            POnFail::STATE__ON_SUCCESS => 'board:c_panel_render',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:c_panel_render' => [
            State::FIELD__ID => 'board:c_panel_render',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \jeyroik\extas\components\dispatchers\DispatcherSuccess::class
            ],
            POnFail::STATE__ON_SUCCESS => 'response:html_render',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'response:html_render' => [
            State::FIELD__ID => 'response:html_render',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\views\ViewHtmlRender::class
            ],
            POnFail::STATE__ON_SUCCESS => '',
            POnFail::STATE__ON_FAILURE => '',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:free_exists' => [
            State::FIELD__ID => 'board:free_exists',
            EMaxTry::STATE__MAX_TRY => 2,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardFreeExists::class
            ],
            POnFail::STATE__ON_SUCCESS => 'board:hero_attach',
            POnFail::STATE__ON_FAILURE => 'board:create',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:hero_attach' => [
            State::FIELD__ID => 'board:hero_attach',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardHeroAttach::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:board_check',
            POnFail::STATE__ON_FAILURE => 'app:failure',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
        'board:create' => [
            State::FIELD__ID => 'board:create',
            EMaxTry::STATE__MAX_TRY => 1,
            State::FIELD__DISPATCHERS => [
                \tratabor\components\dispatchers\boards\BoardCreate::class
            ],
            POnFail::STATE__ON_SUCCESS => 'hero:board_check',
            POnFail::STATE__ON_FAILURE => 'app:terminate',
            EMaxTry::STATE__ON_TERMINATE => 'app:terminate',
        ],
    ]
];
