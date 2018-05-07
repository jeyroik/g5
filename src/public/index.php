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
    echo 'Machine context: <pre>';
    print_r($stateMachine->getStream()->read());
    echo '</pre>';

    $stateMachine->run();

    echo 'Machine context: <pre>';
    print_r($stateMachine->getStream()->read());
    echo '</pre>';

} catch (\Exception $e) {

    echo $e->getMessage();
    echo '<pre>';
    print_r($e);
    echo '</pre>';
}