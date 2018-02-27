<?php

require_once 'vendor/autoload.php';

use Commando\Command;
use Configurator\Config;

$cmd = new Command();

$cmd->option('t')
    ->aka('template')
    ->describedAs('Process template FILE')
    ->expectsFile();

# merge config from non-option arguments
$conf = new Config($cmd->getArgumentValues());

echo json_encode($conf->all()), PHP_EOL;
