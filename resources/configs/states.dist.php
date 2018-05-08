<?php

use tratabor\interfaces\systems\states\IStateFactory as State;

return [
    'app:run' => [
        State::STATE__ID => 'app:run',
        State::STATE__MAX_TRY => 1,
        State::STATE__DISPATCHERS => [
            \tratabor\components\dispatchers\DispatcherTest::class
        ],
        State::STATE__ON_SUCCESS => 'test:to_state',
        State::STATE__ON_FAILURE => '',
        State::STATE__ON_TERMINATE => 'app:terminate',
    ],
    'test:to_state' => [
        State::STATE__ID => 'test:to_state',
        State::STATE__MAX_TRY => 1,
        State::STATE__DISPATCHERS => [
            \tratabor\components\dispatchers\DispatcherTest::class
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
            }
        ],
        State::STATE__ON_SUCCESS => '',
        State::STATE__ON_FAILURE => '',
        State::STATE__ON_TERMINATE => '',
    ],
    'world:exists' => [
        State::STATE__ON_SUCCESS => 'user:is_authorized',
        State::STATE__ON_FAILURE => 'world:create'
    ],
    'user:is_authorized' => [
        State::STATE__ON_SUCCESS => 'user:profile_exists',
        State::STATE__ON_FAILURE => 'world:info_render'
    ],
    'user:profile_exists' => [
        State::STATE__ON_SUCCESS => 'profile:hero_exists',
        State::STATE__ON_FAILURE => 'profile:create'
    ],
    'profile:hero_exists' => [
        State::STATE__ON_SUCCESS => 'hero:board_check',
        State::STATE__ON_FAILURE => 'hero:create'
    ],
    'hero:board_check' => [
        State::STATE__ON_SUCCESS => 'hero:route_exists',
        State::STATE__ON_FAILURE => 'board:free_exists'
    ],
    'hero:route_exists' => [
        State::STATE__ON_SUCCESS => 'request:debug_exists',
        State::STATE__ON_FAILURE => 'route:create'
    ],
    'request:debug_exists' => [
        State::STATE__ON_SUCCESS => 'response:json_render',
        State::STATE__ON_FAILURE => 'board:render'
    ],
    'board:render' => [
        State::STATE__ON_SUCCESS => 'board:c_panel_render',
        State::STATE__ON_FAILURE => ''
    ],
    'board:c_panel_render' => [
        State::STATE__ON_SUCCESS => 'response:html_render',
        State::STATE__ON_FAILURE => ''
    ],
    'board:free_exists' => [
        State::STATE__ON_SUCCESS => 'board:hero_attach',
        State::STATE__ON_FAILURE => 'board:create'
    ],
    'board:hero_attach' => [
        State::STATE__ON_SUCCESS => 'hero:board_check',
        State::STATE__ON_FAILURE => 'hero:create'
    ],
];