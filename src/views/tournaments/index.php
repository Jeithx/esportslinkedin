<div class="page-header">
    <h1>Turnuvalar</h1>
    <p>Tüm aktif, yaklaşan ve tamamlanan turnuvalarımız</p>
</div>

<section>
    <h2>Aktif Turnuvalar</h2>
    
    <?php if (empty($activeTournaments)): ?>
        <div class="alert alert-info">Şu anda aktif turnuva bulunmamaktadır.</div>
    <?php else: ?>
        <div class="tournament-grid">
            <?php foreach ($activeTournaments as $tournament): ?>
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
                            <p><strong>Format:</strong> <?= formatTournamentFormat($tournament['format']) ?></p>
                        </div>
                        <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-primary">Detaylar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="mt-5">
    <h2>Yaklaşan Turnuvalar</h2>
    
    <?php if (empty($upcomingTournaments)): ?>
        <div class="alert alert-info">Şu anda yaklaşan turnuva bulunmamaktadır.</div>
    <?php else: ?>
        <div class="tournament-grid">
            <?php foreach ($upcomingTournaments as $tournament): ?>
                <div class="tournament-card">
                    <div class="tournament-card-header">
                        <h3><?= escape($tournament['name']) ?></h3>
                        <span class="game-badge"><?= escape($tournament['game_name']) ?></span>
                    </div>
                    <div class="tournament-card-body">
                        <div class="tournament-info">
                            <p><strong>Başlangıç:</strong> <?= format_date($tournament['start_date']) ?></p>
                            <p><strong>Ödül Havuzu:</strong> <?= format_money($tournament['prize_pool']) ?></p>
                            <p><strong>Kayıt Başlangıcı:</strong> <?= format_date($tournament['registration_start']) ?></p>
                        </div>
                        <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-secondary">Detaylar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<section class="mt-5">
    <h2>Tamamlanan Turnuvalar</h2>
    
    <?php if (empty($completedTournaments)): ?>
        <div class="alert alert-info">Şu anda tamamlanan turnuva bulunmamaktadır.</div>
    <?php else: ?>
        <div class="tournament-grid">
            <?php foreach ($completedTournaments as $tournament): ?>
                <div class="tournament-card">
                    <div class="tournament-card-header">
                        <h3><?= escape($tournament['name']) ?></h3>
                        <span class="game-badge"><?= escape($tournament['game_name']) ?></span>
                    </div>
                    <div class="tournament-card-body">
                        <div class="tournament-info">
                            <p><strong>Tarih:</strong> <?= format_date($tournament['start_date']) ?> - <?= format_date($tournament['end_date']) ?></p>
                            <p><strong>Ödül Havuzu:</strong> <?= format_money($tournament['prize_pool']) ?></p>
                        </div>
                        <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-outline">Sonuçları Gör</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php  
// Format türünü formatla
function formatTournamentFormat($format) {
    $formats = [
        'single_elimination' => 'Tek Eleme',
        'double_elimination' => 'Çift Eleme',
        'round_robin' => 'Lig Usulü',
        'swiss' => 'İsviçre Sistemi'
    ];
    
    return isset($formats[$format]) ? $formats[$format] : $format;
}
?>