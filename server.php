<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * This file allows us to emulate Apache's "mod_rewrite" functionality from the
 * built-in PHP web server. This provides a convenient way to test a Laravel
 * application without having installed a "real" web server software here.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve static files from /public directory
if ($uri !== '/' && $uri !== '') {
    $publicPath = __DIR__ . '/public' . $uri;

    // Check real path (resolves symlinks) for static file serving
    if (is_file($publicPath) || (realpath($publicPath) && is_file(realpath($publicPath)))) {
        // Determine content type
        $ext = pathinfo($uri, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css'  => 'text/css',
            'js'   => 'application/javascript',
            'json' => 'application/json',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'webp' => 'image/webp',
            'ico'  => 'image/x-icon',
            'woff' => 'font/woff',
            'woff2'=> 'font/woff2',
            'ttf'  => 'font/ttf',
        ];

        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
            readfile($publicPath);
            return;
        }

        return false;
    }
}

require_once __DIR__ . '/public/index.php';
