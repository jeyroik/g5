<?php

use tratabor\interfaces\systems\states\IStateFactory as State;
use tratabor\interfaces\systems\states\IStateMachine as Machine;

return [
    Machine::MACHINE__CONFIG => [
        Machine::MACHINE__CONFIG__VERSION => '1.0',
        Machine::MACHINE__CONFIG__ALIAS => 'primary machine',
        Machine::MACHINE__CONFIG__START_STATE => 'app:run',
        Machine::MACHINE__CONFIG__END_STATE => 'app:terminate',
    ],

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
    ],
    'app:terminate' => [
        State::STATE__ID => 'app:terminate',
        State::STATE__MAX_TRY => 1,
        State::STATE__DISPATCHERS => [
            function ($currentState, $context) {
                echo 'App termination...<br/><pre>';
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
        State::STATE__DISPATCHERS => [
            \tratabor\components\dispatchers\DispatcherSuccess::class
        ],
        State::STATE__ON_SUCCESS => [
            Machine::MACHINE__CONFIG => [
                Machine::MACHINE__CONFIG__VERSION => '1.0',
                Machine::MACHINE__CONFIG__ALIAS => 'test sub machine',
                Machine::MACHINE__CONFIG__START_STATE => 'hero:board_check :: sub:check1',
                Machine::MACHINE__CONFIG__END_STATE => 'sub:app:terminate',
            ],
            'hero:board_check :: sub:check1' => [
                State::STATE__ID => 'hero:board_check :: sub:check1',
                State::STATE__DISPATCHERS => [
                    \tratabor\components\dispatchers\DispatcherSuccess::class
                ],
                State::STATE__ON_SUCCESS => 'hero:board_check :: sub:check2',
                State::STATE__ON_FAILURE => 'hero:board_check :: sub:check3',
                State::STATE__ON_TERMINATE => 'sub::app:terminate',
            ],
            'hero:board_check :: sub:check2' => [
                State::STATE__ID => 'hero:board_check :: sub:check2',
                State::STATE__DISPATCHERS => [
                    \tratabor\components\dispatchers\DispatcherSuccess::class
                ],
                State::STATE__ON_SUCCESS => '',
                State::STATE__ON_FAILURE => '',
                State::STATE__ON_TERMINATE => 'sub::app:terminate',
            ],
            'sub:app:terminate' => [
                State::STATE__ID => 'sub:app:terminate',
                State::STATE__DISPATCHERS => [
                    \tratabor\components\dispatchers\DispatcherSuccess::class
                ],
                State::STATE__ON_SUCCESS => '',
                State::STATE__ON_FAILURE => '',
                State::STATE__ON_TERMINATE => '',
            ]
        ],
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
            \tratabor\components\dispatchers\DispatcherSuccess::class
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
        State::STATE__DISPATCHERS => [
            \tratabor\components\dispatchers\DispatcherSuccess::class
        ],
        State::STATE__ON_SUCCESS => 'board:hero_attach',
        State::STATE__ON_FAILURE => 'board:create',
        State::STATE__ON_TERMINATE => 'app:terminate',
    ],
    'board:hero_attach' => [
        State::STATE__ID => 'board:hero_attach',
        State::STATE__DISPATCHERS => [
            \tratabor\components\dispatchers\DispatcherSuccess::class
        ],
        State::STATE__ON_SUCCESS => 'hero:board_check',
        State::STATE__ON_FAILURE => 'app:terminate',
        State::STATE__ON_TERMINATE => 'app:terminate',
    ],
];