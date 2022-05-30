<?php

define('INDEX', true);

include '../../config.php';
include '../../inc/utils.php';

$url = 'https://www.pornhub.com/view_video.php?viewkey=ph6116a13a48187';

$content = curl($url);

if (!preg_match('/document\.cookie="RNKEY="\+n\+/', $content)) {
    $content = file_get_contents('sample.html');
}

preg_match('/function(?:[^}]*+})++/', $content, $matches);

include '../../inc/ph/second-method.php';

header('Content-Type: text/html');

echo 'Cookie to bypass: <b>' . $cookie . '</b><br>';
echo '<pre>' . htmlspecialchars($content) . '</pre>';
