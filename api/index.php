<?php

error_reporting(E_ALL & ~E_DEPRECATED);

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

if (!isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')) {
    if (isset($_SERVER['HTTP_HOST']) && strpos($_SERVER['HTTP_HOST'], 'vercel.app') !== false) {
        $_SERVER['HTTPS'] = 'on';
    }
}

$certSources = [
    __DIR__ . '/../cert/isrgrootx1.pem',
    __DIR__ . '/../cert/tidb-bundle.pem',
];
foreach ($certSources as $src) {
    if (file_exists($src) && is_readable($src)) {
        @copy($src, '/tmp/tidb-ca.pem');
        putenv('DB_SSL_CA=/tmp/tidb-ca.pem');
        break;
    }
}

require __DIR__ . '/../public/index.php';
