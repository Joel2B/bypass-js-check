<?php

defined('INDEX') || die();

$lock_file = 'inc/tmp/J4P5.lock';

if (!file_exists($lock_file)) {
    mkdir('inc/tmp');

    file_put_contents($lock_file, '0#0');
}

$lock = file_get_contents($lock_file);
$lock = explode('#', $lock);

$lock_time   = $lock[0];
$lock_status = $lock[1];

if ($lock_status === '0' || $lock_time <= time()) {
    $expiry = time() + 30;
    $status = 1;

    $data = "$expiry#$status";

    file_put_contents($lock_file, $data);
} else {
    while ($lock_status === '1' && $lock_time > time()) {
        $lock = file_get_contents($lock_file);
        $lock = explode('#', $lock);

        $lock_time   = $lock[0];
        $lock_status = $lock[1];

        sleep(INTERVAL_SLEEP);
    }

    $cache->check();

    $cookie = !empty($cache->data) ? $cache->data : $cookie;

    echo $cookie;

    die();
}

include 'inc/js/js.php';

$patterns = array(
    '<html><head><script type="text\/javascript"><!--' => '',
    'if \(isNaN.*|if \(typeof (phantom|module).*\;'    => '',
    'i<=m'                                             => 'i<m',
    'document\.cookie="'                               => 'print("',
    '\;path=/\;"'                                      => '")',
    'document\.location\.reload\(true\)\;'             => '',
    '\/\/[^}]++'                                       => '',
);

exec_patterns($patterns, $content);

$content .= 'go();';

ob_start();

js::run($content);

$cookie = ob_get_contents();

ob_clean();

file_put_contents($lock_file, '0#0');
