#!/usr/bin/env php
<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

define("APP_ROOT_KEY", "users");

\ThirdBridge\Cli\CustomCommand::execute($argv);