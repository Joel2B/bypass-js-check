<?php

defined('INDEX') || die();

preg_match('/function(?:[^}]*+})++/', $content, $matches);

$code = $matches[0];

// provisional
$patterns = array(
    "if.*(NaN|m'|e');"                            => '',
    '(?![fuo.r])(n|m|i|p|s)((?![fctoq.a e])| >>)' => '$$1$2',
    '(?<=")\+|\+(?=")'                            => '.',
    'document\.cookie=(".*")'                     => 'return $1',
    '(var|Math.|document.*;)'                     => '',
);

exec_patterns($patterns, $code);

// this is extremely dangerous
eval($code);

$cookie = explode(';', go());
$cookie = $cookie[0];
