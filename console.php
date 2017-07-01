#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Console\Application;

define("APP_ROOT_KEY", "users");

$application = new Application();
$command = new ThirdBridge\Commands\UsersScriptCommand();
$application->add($command);

$application->setDefaultCommand($command->getName());

$application->run();