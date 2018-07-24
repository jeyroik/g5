<?php

define('G5__ROOT_PATH', __DIR__ . '/../..');
define('EXTAS__APPLICATION_PATH', __DIR__ . '/../..');

require(G5__ROOT_PATH . '/vendor/autoload.php');

if (is_file(G5__ROOT_PATH . '/.env')) {
    $dotenv = new \Dotenv\Dotenv(G5__ROOT_PATH . '/');
    $dotenv->load();
}

if (!is_file(G5__ROOT_PATH . '/resources/configs/states.php')) {
    exit('Missed basic configuration #13');
}

$statesConfig = include G5__ROOT_PATH . '/resources/configs/states.php';
$stateMachine = new \jeyroik\extas\components\systems\states\StateMachine($statesConfig);

try {
    $stateMachine->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

/**
 * @var $stateMachine \jeyroik\extas\interfaces\systems\states\machines\extensions\IStatesRoute
 */

echo '
<div class="row mt-5">
    <div class="col-md-12">
        States route:<pre>' . print_r($stateMachine->getRoute(), true) . '</pre>
    </div>
</div>
';
