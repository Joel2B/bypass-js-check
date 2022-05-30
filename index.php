<?php
// TODO: use POO

if (empty($_GET['url'])) {
    die();
}

$allowed_ips = array(
    '*',
);

$allowed_ips_force = array(
    '*',
);

$user_ip = $_SERVER['REMOTE_ADDR'];

if (!in_array($user_ip, $allowed_ips) && !in_array('*', $allowed_ips)) {
    die();
}

// bypass cache
$allow_forced = in_array($user_ip, $allowed_ips_force) || in_array('*', $allowed_ips_force);

define('INDEX', true);

include 'config.php';
include 'inc/utils.php';

$cookie  = 'null=null';
$url     = $_GET['url'];
$forced  = isset($_GET['force']);
$content = curl($url);

header('Content-Type: text/plain');

// infinityfree
if (preg_match_all('/toNumbers\("(.*?)\"\)/', $content, $match)) {
    include 'inc/slow-aes.php';

    $hash   = array_map('toNumbers', $match[1]);
    $aes    = new AES();
    $token  = $aes->decrypt($hash[2], 16, 2, $hash[0], 16, $hash[1]);
    $cookie = '__test=' . toHex($token);
}

// stackpath
if (preg_match('/(sbtsck=.*?);/', $content, $match)) {
    $cookie = $match[1];
}

// pornhub
if (preg_match('/pornhub\.com/', $url)) {
    include 'inc/cache.php';

    $cache = new Cache('pornhub.cookie', COOKIE_DURATION);

    if (($cache->check() && !$forced) || !$allow_forced) {
        $cookie = $cache->data;
    } else if (preg_match('/document\.cookie="RNKEY="\+n\+/', $content)) {
        if (USE_FIRST_METHOD_PH) {
            include 'inc/ph/first-method.php';
        } else {
            include 'inc/ph/second-method.php';
        }

        $cache->save($cookie);
    }
}

echo $cookie;
