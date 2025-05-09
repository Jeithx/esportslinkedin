<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sayfa Bulunamadı - <?= SITE_NAME ?></title>
    <link rel="stylesheet" href="<?= url('/assets/css/main.css') ?>">
    <style>
        .error-container {
            text-align: center;
            padding: 100px 0;
        }
        
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 20px;
        }
        
        .error-message {
            font-size: 24px;
            margin-bottom: 30px;
        }
        
        .error-description {
            margin-bottom: 30px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-code">404</div>
            <div class="error-message">Sayfa Bulunamadı</div>
            <div class="error-description">
                Aradığınız sayfa mevcut değil veya taşınmış olabilir.
            </div>
            <a href="<?= url('/') ?>" class="btn btn-primary">Ana Sayfaya Dön</a>
        </div>
    </div>
</body>
</html>