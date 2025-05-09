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
                
                <nav class="hidden md:block">
                    <ul class="flex space-x-6">
                        <li><a href="<?= url('/') ?>" class="hover:text-indigo-300 transition">Ana Sayfa</a></li>
                        <li><a href="<?= url('/tournaments') ?>" class="hover:text-indigo-300 transition">Turnuvalar</a></li>
                        <li><a href="<?= url('/teams') ?>" class="hover:text-indigo-300 transition">Takımlar</a></li>
                        <?php if (Auth::isLoggedIn()): ?>
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