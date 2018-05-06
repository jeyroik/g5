<?php

use tratabor\interfaces\systems\states\IStateFactory as State;

return [
    'app:run' => [
        State::STATE__ID => 'app:run',
        State::STATE__MAX_TRY => 1,
        State::STATE__DISPATCHERS => [],
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