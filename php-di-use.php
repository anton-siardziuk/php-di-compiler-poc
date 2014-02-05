<?php

require __DIR__.'/vendor/autoload.php';

define('TIMES', 1);

$container = require __DIR__.'/cache/php-di/container.php';
$timeStart = microtime(true);
for ($i = 0; $i < TIMES; $i++) {
    $baz = $container->get('Example\Baz');
}
echo sprintf("Compiled to one file  : %s\n", microtime(true) - $timeStart);

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(__DIR__.'/php-di-definitions.php');
$container = $builder->build();
$timeStart = microtime(true);
for ($i = 0; $i < TIMES; $i++) {
    $baz = $container->get('Example\Baz');
}
echo sprintf("Not compiled          : %s\n", microtime(true) - $timeStart);

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions(__DIR__.'/php-di-definitions.php');
$builder->compileContainer(__DIR__.'/cache/php-di');
$container = $builder->build();
$timeStart = microtime(true);
for ($i = 0; $i < TIMES; $i++) {
    $baz = $container->get('Example\Baz');
}
echo sprintf("Compiled to many files: %s\n", microtime(true) - $timeStart);