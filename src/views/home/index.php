<div class="hero-section">
    <div class="hero-content">
        <h1>Boscaler Espor Turnuvalarına Hoş Geldiniz</h1>
        <p>Profesyonel espor turnuvalarına katılın ve yeteneklerinizi gösterin.</p>
        <a href="<?= url('/tournaments') ?>" class="btn btn-primary">Turnuvalara Göz At</a>
    </div>
</div>

<section class="featured-section">
    <h2>Öne Çıkan Turnuvalar</h2>
    
    <?php if (empty($latestTournaments)): ?>
        <div class="alert alert-info">Şu anda aktif turnuva bulunmamaktadır.</div>
    <?php else: ?>
        <div class="tournament-grid">
            <?php foreach ($latestTournaments as $tournament): ?>
                <div class="tournament-card">
                    <div class="tournament-card-header">
                        <h3><?= escape($tournament['name']) ?></h3>
                        <span class="game-badge"><?= escape($tournament['game_name']) ?></span>
                    </div>
                    <div class="tournament-card-body">
                        <div class="tournament-info">
                            <p><strong>Başlangıç:</strong> <?= format_date($tournament['start_date']) ?></p>
                            <p><strong>Ödül Havuzu:</strong> <?= format_money($tournament['prize_pool']) ?></p>
                            <p><strong>Takım Sayısı:</strong> <?= escape($tournament['team_limit']) ?></p>
                        </div>
                        <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-secondary">Detaylar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="view-all-section">
        <a href="<?= url('/tournaments') ?>" class="view-all-link">Tüm Turnuvaları Gör</a>
    </div>
</section>

<section class="featured-section">
    <h2>Öne Çıkan Takımlar</h2>
    
    <?php if (empty($latestTeams)): ?>
        <div class="alert alert-info">Henüz kayıtlı takım bulunmamaktadır.</div>
    <?php else: ?>
        <div class="team-grid">
            <?php foreach ($latestTeams as $team): ?>
                <div class="team-card">
                    <div class="team-logo">
                        <?php if (!empty($team['logo'])): ?>
                            <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo">
                        <?php else: ?>
                            <div class="default-logo"><?= substr($team['name'], 0, 2) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="team-info">
                        <h3><?= escape($team['name']) ?></h3>
                        <p><?= escape($team['description']) ?></p>
                        <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="btn btn-sm btn-outline">Takımı Görüntüle</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="view-all-section">
        <a href="<?= url('/teams') ?>" class="view-all-link">Tüm Takımları Gör</a>
    </div>
</section>

<section class="about-section">
    <div class="about-content">
        <h2>Boscaler Esports Hakkında</h2>
        <p>Boscaler Esports, League of Legends, Valorant, CS2 ve Rainbow Six Siege gibi popüler oyunlarda profesyonel turnuvalar düzenleyen bir organizasyondur. Amacımız, espor tutkunları için adil, rekabetçi ve eğlenceli bir ortam sağlamaktır.</p>
        <p>Turnuvalarımız, her seviyeden oyuncuya açıktır ve özel ödüller sunmaktadır. Takımınızı oluşturun, yeteneklerinizi gösterin ve espor sahnesinde yerinizi alın!</p>
    </div>
</section>