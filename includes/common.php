<?php

// Production errors handling
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

// Common security headers could be set in Apache config but prefer
// keep everything in one place
header('Strict-Transport-Security: max-age=31536000; includeSubdomains; preload');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
// header("Content-Security-Policy: default-src 'self' audioguide.mnw.art.pl 192.168.100.78; script-src 'self' audioguide.mnw.art.pl 192.168.100.78;");

// Define include dir
$incdir = '/var/www/include_audio/';

// Safely determine lang inclusion
$lang_param = filter_input(
    INPUT_GET,
    'lang',
    FILTER_VALIDATE_REGEXP,
    ['options'=>['regexp'=>'/^(pl|en)$/']]
);
if ($lang_param === false || $lang_param === null) {
    $lang_param = 'pl';
}

if ($lang_param === 'en' && file_exists($incdir . 'lang_en.php')) {
    require $incdir . 'lang_en.php';
} else {
    require $incdir . 'lang_pl.php';
}

?>
