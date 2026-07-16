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

require __DIR__ . '/../public/index.php';
