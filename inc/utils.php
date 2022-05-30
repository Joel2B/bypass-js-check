<?php

function toHex($args) {
    if (func_num_args() != 1 || !is_array($args)) {
        $args = func_get_args();
    }

    $ret = '';

    for ($i = 0; $i < count($args); $i++) {
        $ret .= sprintf('%02x', $args[$i]);
    }

    return $ret;
}

function toNumbers($s) {
    $ret = array();

    for ($i = 0; $i < strlen($s); $i += 2) {
        $ret[] = hexdec(substr($s, $i, 2));
    }

    return $ret;
}

function curl($url) {
    $curl = curl_init();

    $options = array(
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_CONNECTTIMEOUT => CONNECTTIMEOUT,
        CURLOPT_TIMEOUT        => TIMEOUT,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
    );

    curl_setopt_array($curl, $options);

    $response = curl_exec($curl);

    curl_close($curl);

    return $response;
}

function exec_patterns($patterns, &$content) {
    foreach ($patterns as $pattern => $replace) {
        $content = preg_replace("#$pattern#", $replace, $content);
    }
}
