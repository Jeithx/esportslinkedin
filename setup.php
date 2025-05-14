<?php
// Hata raporlamayı etkinleştir
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Klasör yolları tanımı
define('ROOT_PATH', __DIR__);
define('SRC_PATH', ROOT_PATH . '/src');
define('CONFIG_PATH', SRC_PATH . '/config');
define('CORE_PATH', SRC_PATH . '/core');
define('DATABASE_PATH', ROOT_PATH . '/database');

// Temel yapılandırma dosyasını dahil et
require_once CONFIG_PATH . '/config.php';

// Önce Database sınıfını dahil et
require_once CORE_PATH . '/Database.php';

// Sonra veritabanı bağlantısını dahil et
require_once CONFIG_PATH . '/database.php';

// Veritabanı tablolarını oluştur
echo "<h1>Veritabanı Kurulum Aracı</h1>";

try {
    // Tablo var mı kontrol et - bu sorguyu çalıştırabilmek için try-catch içine alıyoruz
    try {
        $tableCheck = $pdo->query("SHOW TABLES LIKE 'games'")->rowCount();
    } catch (PDOException $e) {
        // Tablo yok veya veritabanı yok
        $tableCheck = 0;
    }
    
    if ($tableCheck > 0) {
        // Tabloları temizle
        echo "<h2>Var Olan Tabloları Temizleme</h2>";
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
        $tables = [
            'matches',
            'tournament_teams',
            'tournaments',
            'team_members',
            'teams',
            'games',
            'users'
        ];
        
        foreach ($tables as $table) {
            $pdo->exec("TRUNCATE TABLE {$table}");
            echo "<p>✓ {$table} tablosu temizlendi.</p>";
        }
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
    } else {
        // SQL dosyalarını oku ve çalıştır
        $migrationFiles = [
            'users.sql',
            'games.sql',
            'teams.sql',
            'team_members.sql',
            'tournaments.sql',
            'tournament_teams.sql',
            'matches.sql',
            'team_invitations.sql',
            'player_search.sql'
        ];

        echo "<h2>Tabloları Oluşturma</h2>";
        foreach ($migrationFiles as $file) {
            $path = DATABASE_PATH . '/migrations/' . $file;
            if (file_exists($path)) {
                $sql = file_get_contents($path);
                $pdo->exec($sql);
                echo "<p>✓ {$file} başarıyla çalıştırıldı.</p>";
            } else {
                echo "<p>✗ {$file} bulunamadı!</p>";
            }
        }
    }

    // Örnek verileri ekle
    echo "<h2>Örnek Verileri Ekleme</h2>";
    $seedFiles = [
        'games.sql',
        'users.sql'
    ];

    foreach ($seedFiles as $file) {
        $path = DATABASE_PATH . '/seeds/' . $file;
        if (file_exists($path)) {
            $sql = file_get_contents($path);
            $pdo->exec($sql);
            echo "<p>✓ {$file} örnek verileri başarıyla eklendi.</p>";
        } else {
            echo "<p>✗ {$file} bulunamadı!</p>";
        }
    }

    echo "<h2>Kurulum Tamamlandı!</h2>";
    echo "<p>Veritabanı başarıyla kuruldu. <a href='http://localhost/boscaler-esports/public'>Siteye git</a></p>";

} catch (PDOException $e) {
    echo "<h2>Hata!</h2>";
    echo "<p>Kurulum sırasında bir hata oluştu: " . $e->getMessage() . "</p>";
}