<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? escape($pageTitle) . ' - ' . SITE_NAME : SITE_NAME ?> Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('/assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= url('/assets/css/admin.css') ?>">
    <?php if (isset($cssFiles) && is_array($cssFiles)): ?>
        <?php foreach ($cssFiles as $cssFile): ?>
            <link rel="stylesheet" href="<?= url('/assets/css/' . $cssFile) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="admin-panel">
    <header class="admin-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="<?= url('/admin') ?>"><?= SITE_NAME ?> Admin</a>
                </div>
                <div class="user-info">
                    <span><?= Session::get('user_name') ?></span>
                    <a href="<?= url('/logout') ?>" class="btn btn-sm btn-danger">Çıkış Yap</a>
                </div>
            </div>
        </div>
    </header>
    
    <div class="admin-container">
        <aside class="admin-sidebar">
            <nav>
                <ul>
                    <li><a href="<?= url('/admin') ?>">Dashboard</a></li>
                    <li><a href="<?= url('/admin/tournaments') ?>">Turnuvalar</a></li>
                    <li><a href="<?= url('/admin/teams') ?>">Takımlar</a></li>
                    <li><a href="<?= url('/admin/users') ?>">Kullanıcılar</a></li>
                    <li><a href="<?= url('/') ?>" target="_blank">Siteyi Görüntüle</a></li>
                </ul>
            </nav>
        </aside>
        
        <main class="admin-content">
            <?= flash_messages() ?>
            <?= $content ?? '' ?>
        </main>
    </div>
    
    <script src="<?= url('/assets/js/main.js') ?>"></script>
    <script src="<?= url('/assets/js/admin.js') ?>"></script>
    <?php if (isset($jsFiles) && is_array($jsFiles)): ?>
        <?php foreach ($jsFiles as $jsFile): ?>
            <script src="<?= url('/assets/js/' . $jsFile) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>