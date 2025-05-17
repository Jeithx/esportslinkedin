<?php
// src/views/layouts/main.php dosyasının en üstünde
require_once __DIR__ . '/../../helpers/notifications.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? escape($pageTitle) . ' - ' . SITE_NAME : SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="<?= url('/assets/css/main.css') ?>">
    <?php if (isset($cssFiles) && is_array($cssFiles)): ?>
        <?php foreach ($cssFiles as $cssFile): ?>
            <link rel="stylesheet" href="<?= url('/assets/css/' . $cssFile) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <header class="bg-indigo-900 text-white shadow-md">
        <div class="container mx-auto">
            <div class="flex justify-between items-center py-4 px-6">
                <div class="text-2xl font-bold">
                    <a href="<?= url('/') ?>"><?= SITE_NAME ?></a>
                </div>
                
                <!-- Mobile menu button -->
                <button class="md:hidden mobile-menu-toggle">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                
                <!-- src/views/layouts/main.php dosyasındaki navigasyon menüsünde -->
                <nav class="hidden md:block">
                    <ul class="flex space-x-6">
                        <li><a href="<?= url('/') ?>" class="hover:text-indigo-300 transition">Ana Sayfa</a></li>
                        <li><a href="<?= url('/tournaments') ?>" class="hover:text-indigo-300 transition">Turnuvalar</a></li>
                        <li><a href="<?= url('/teams') ?>" class="hover:text-indigo-300 transition">Takımlar</a></li>
                        <li><a href="<?= url('/teams/listings') ?>" class="hover:text-indigo-300 transition">Eksik Oyuncu İlanları</a></li>
                        <?php if (Auth::isLoggedIn()): ?>
                                            <li class="relative">
                        <a href="#" class="hover:text-indigo-300 transition" id="notification-bell">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            
                            <?php 
                            $notificationCount = Notification::countUnread(Session::get('user_id'));
                            if ($notificationCount > 0): 
                            ?>
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    <?= $notificationCount > 9 ? '9+' : $notificationCount ?>
                                </span>
                            <?php endif; ?>
                        </a>
                        
                        <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg overflow-hidden z-20">
                            <div class="p-3 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-sm font-semibold text-gray-700">Bildirimler</h3>
                                <button id="mark-all-read" class="text-xs text-indigo-600 hover:text-indigo-800">Tümünü Okundu İşaretle</button>
                            </div>
                            
                            <div class="notification-list max-h-60 overflow-y-auto">
                                <?php 
                                $notifications = Notification::getUnread(Session::get('user_id'));
                                if (empty($notifications)): 
                                ?>
                                    <div class="p-4 text-sm text-center text-gray-500">
                                        Bildirim bulunmamaktadır
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($notifications as $notification): ?>
                                        <a href="<?= !empty($notification['link']) ? url($notification['link']) : '#' ?>" class="block p-3 hover:bg-gray-50 border-b border-gray-100" data-notification-id="<?= $notification['id'] ?>">
                                            <div class="flex items-start">
                                                <div class="w-2 h-2 bg-indigo-500 rounded-full mt-1.5 mr-2"></div>
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-800"><?= escape($notification['title']) ?></p>
                                                    <p class="text-xs text-gray-500 mt-1"><?= escape($notification['message']) ?></p>
                                                    <span class="text-xs text-gray-400 mt-1"><?= time_ago($notification['created_at']) ?></span>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="p-2 border-t border-gray-200 bg-gray-50 text-center">
                                <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800">Tüm Bildirimleri Görüntüle</a>
                            </div>
                        </div>
                    </li>
                            <li><a href="<?= url('/profile') ?>" class="hover:text-indigo-300 transition">Profilim</a></li>
                            <?php if (Auth::isAdmin()): ?>
                                <li><a href="<?= url('/admin') ?>" class="hover:text-indigo-300 transition">Admin Panel</a></li>
                            <?php endif; ?>
                            <li><a href="<?= url('/logout') ?>" class="hover:text-indigo-300 transition">Çıkış Yap</a></li>
                        <?php else: ?>
                            <li><a href="<?= url('/login') ?>" class="hover:text-indigo-300 transition">Giriş Yap</a></li>
                            <li><a href="<?= url('/register') ?>" class="px-4 py-2 bg-indigo-700 hover:bg-indigo-600 rounded-lg transition">Kayıt Ol</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            
            <!-- Mobile menu (hidden by default) -->
        <div class="md:hidden hidden mobile-menu">
            <ul class="py-4 px-6 space-y-4">
                <li><a href="<?= url('/') ?>">Ana Sayfa</a></li>
                <li><a href="<?= url('/tournaments') ?>">Turnuvalar</a></li>
                <li><a href="<?= url('/teams') ?>">Takımlar</a></li>
                <li><a href="<?= url('/teams/listings') ?>">Oyuncu İlanları</a></li>
                <?php if (Auth::isLoggedIn()): ?>
                    <li><a href="<?= url('/profile') ?>">Profilim</a></li>
                    <?php if (Auth::isAdmin()): ?>
                        <li><a href="<?= url('/admin') ?>">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><a href="<?= url('/logout') ?>">Çıkış Yap</a></li>
                <?php else: ?>
                    <li><a href="<?= url('/login') ?>">Giriş Yap</a></li>
                    <li><a href="<?= url('/register') ?>">Kayıt Ol</a></li>
                <?php endif; ?>
            </ul>
        </div>
        </div>
    </header>
    
    <main class="main-content">
        <div class="container">
            <?= flash_messages() ?>
            <?= $content ?? '' ?>
        </div>
    </main>
    
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Hakkımızda</h3>
                    <p>Boscaler Esports, profesyonel espor turnuvaları düzenleyen bir organizasyondur.</p>
                </div>
                <div class="footer-section">
                    <h3>Hızlı Bağlantılar</h3>
                    <ul>
                        <li><a href="<?= url('/') ?>">Ana Sayfa</a></li>
                        <li><a href="<?= url('/tournaments') ?>">Turnuvalar</a></li>
                        <li><a href="<?= url('/teams') ?>">Takımlar</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>İletişim</h3>
                    <p>Email: <?= SITE_EMAIL ?></p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> <?= SITE_NAME ?>. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </footer>
    
    <script src="<?= url('/assets/js/main.js') ?>"></script>
    <?php if (isset($jsFiles) && is_array($jsFiles)): ?>
        <?php foreach ($jsFiles as $jsFile): ?>
            <script src="<?= url('/assets/js/' . $jsFile) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>