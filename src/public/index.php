<?php

define('G5__ROOT_PATH', __DIR__ . '/../..');

require(G5__ROOT_PATH . '/vendor/autoload.php');

if (is_file(G5__ROOT_PATH . '/.env')) {
    $dotenv = new \Dotenv\Dotenv(G5__ROOT_PATH . '/');
    $dotenv->load();
}

if (!is_file(G5__ROOT_PATH . '/resources/configs/states.php')) {
    exit('Missed basic configuration #13');
}

$statesConfig = include G5__ROOT_PATH . '/resources/configs/states.php';
$stateMachine = new \tratabor\components\systems\states\StateMachine($statesConfig);

try {
    $stateMachine->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}

echo '
<div class="row mt-5">
    <div class="col-md-12">
        States route:<pre>' . print_r($stateMachine->getStatesRoute(), true) . '</pre>
    </div>
</div>
';
