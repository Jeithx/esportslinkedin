<?php
// Veritabanı yapılandırması
$db_config = [
    'host' => 'localhost',
    'username' => 'root', // Geliştirme ortamı için, canlıda değiştir
    'password' => '',     // Geliştirme ortamı için, canlıda değiştir
    'database' => 'boscaler_esports',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];

// Veritabanı bağlantısı için PDO örneği oluştur
try {
    $dsn = "mysql:host={$db_config['host']};dbname={$db_config['database']};charset={$db_config['charset']}";
    $pdo = new PDO($dsn, $db_config['username'], $db_config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}

// Database nesnesi class tanımlandıysa oluştur
if (class_exists('Database')) {
    $database = new Database($pdo);
}