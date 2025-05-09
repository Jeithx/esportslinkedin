<?php
// Site yapılandırması
$config = [
    'site' => [
        'name' => 'Boscaler Espor',
        'url' => 'http://localhost/boscaler-esports/public', // Geliştirme ortamı için
        'email' => 'info@boscaler.com',
        'description' => 'Profesyonel Espor Turnuva Organizasyonu',
        'timezone' => 'Europe/Istanbul',
    ],
    'paths' => [
        'uploads' => ROOT_PATH . '/public/uploads',
        'images' => ROOT_PATH . '/public/assets/images',
    ],
    'games' => [
        'lol' => 'League of Legends',
        'valorant' => 'Valorant',
        'cs2' => 'Counter-Strike 2',
        'r6' => 'Rainbow Six Siege'
    ]
];

// Sabit olarak tanımla
define('SITE_NAME', $config['site']['name']);
define('SITE_URL', $config['site']['url']);
define('SITE_EMAIL', $config['site']['email']);
define('UPLOADS_PATH', $config['paths']['uploads']);

// Zaman dilimini ayarla
date_default_timezone_set($config['site']['timezone']);