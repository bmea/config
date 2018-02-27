#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

# parse arguments
$cmd = new Commando\Command();

$cmd->option('t')
    ->aka('template')
    ->required()
    ->describedAs('Process template FILE')
    ->expectsFile();

# compile template
$m = new Mustache_Engine;
$tpl = $m->loadTemplate(file_get_contents($cmd['template']));

# merge config from non-option arguments
$conf = new Noodlehaus\Config($cmd->getArgumentValues());

# render template
echo $tpl->render($conf->all());
