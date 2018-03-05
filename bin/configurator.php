#!/usr/bin/env php
<?php

require_once __DIR__.'/../lib/configurator/vendor/autoload.php';

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

# explode dot-notation
function explodeDotNotation($arr) {
    foreach ($arr as $k => $v) {
        $keys = explode('.', $k);
        $r = &$arr;
        foreach ($keys as $key) {
            $r = &$r[$key];
        }
        $r = $v;

        if (is_array($v)) {
            $r = explodeDotNotation($v);
        }
    }
    return $arr;
}
$conf = explodeDotNotation($conf->all());

# render template
echo $tpl->render($conf);
