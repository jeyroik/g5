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
        State::STATE__ON_TERMINATE => '',
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
    ]
];