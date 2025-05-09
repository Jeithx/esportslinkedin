<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? escape($pageTitle) . ' - ' . SITE_NAME : SITE_NAME ?></title>
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
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="<?= url('/') ?>"><?= SITE_NAME ?></a>
                </div>
                <nav>
                    <ul>
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
                </nav>
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