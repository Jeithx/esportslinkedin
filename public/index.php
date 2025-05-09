<?php
// Hata raporlamayı etkinleştir
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Oturum başlat
session_start();

// Klasör yolları tanımı
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('CONFIG_PATH', SRC_PATH . '/config');
define('CORE_PATH', SRC_PATH . '/core');
define('CONTROLLER_PATH', SRC_PATH . '/controllers');
define('MODEL_PATH', SRC_PATH . '/models');
define('VIEW_PATH', SRC_PATH . '/views');
define('HELPER_PATH', SRC_PATH . '/helpers');

// Otomatik sınıf yükleyici
spl_autoload_register(function($className) {
    // Önce controller klasöründe ara
    $controllerFile = CONTROLLER_PATH . "/{$className}.php";
    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        return;
    }
    
    // Sonra core klasöründe ara
    $coreFile = CORE_PATH . "/{$className}.php";
    if (file_exists($coreFile)) {
        require_once $coreFile;
        return;
    }
    
    // Model klasöründe ara
    $modelFile = MODEL_PATH . "/{$className}.php";
    if (file_exists($modelFile)) {
        require_once $modelFile;
        return;
    }
    
    // Helper sınıflar
    $helperFile = HELPER_PATH . "/{$className}.php";
    if (file_exists($helperFile)) {
        require_once $helperFile;
        return;
    }
});

// Temel gerekli dosyaları dahil et
require_once CORE_PATH . '/Database.php';
require_once CORE_PATH . '/Router.php';
require_once CORE_PATH . '/Session.php';
require_once CORE_PATH . '/Auth.php';
require_once CONFIG_PATH . '/config.php';
require_once CONFIG_PATH . '/database.php';
require_once HELPER_PATH . '/functions.php';
require_once HELPER_PATH . '/validation.php'; // Validation sınıfını dahil ettik

// Rota yapılandırmasını dahil et
require_once CONFIG_PATH . '/routes.php';

// Router'ı çalıştır
$router->dispatch();