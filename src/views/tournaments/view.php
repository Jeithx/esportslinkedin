<?php 
// Turnuva durumunu formatla
function formatTournamentStatus($status) {
    $statuses = [
        'draft' => 'Taslak',
        'registration' => 'Kayıt Açık',
        'active' => 'Aktif',
        'completed' => 'Tamamlandı',
        'cancelled' => 'İptal Edildi'
    ];
    
    $classes = [
        'draft' => 'status-draft',
        'registration' => 'status-registration',
        'active' => 'status-active',
        'completed' => 'status-completed',
        'cancelled' => 'status-cancelled'
    ];
    
    $statusText = isset($statuses[$status]) ? $statuses[$status] : $status;
    $statusClass = isset($classes[$status]) ? $classes[$status] : '';
    
    return '<span class="tournament-status ' . $statusClass . '">' . $statusText . '</span>';
}

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

<div class="tournament-header">
    <?php if (!empty($tournament['banner'])): ?>
        <img src="<?= url('/uploads/tournament_banners/' . $tournament['banner']) ?>" alt="<?= escape($tournament['name']) ?>" class="tournament-banner">
    <?php endif; ?>
    
    <h1 class="tournament-title">
        <?= escape($tournament['name']) ?>
        <?= formatTournamentStatus($tournament['status']) ?>
    </h1>
    
    <div class="tournament-meta">
        <div class="tournament-meta-item">
            <i class="fas fa-gamepad"></i> <?= escape($tournament['game_name']) ?>
        </div>
        <div class="tournament-meta-item">
            <i class="fas fa-calendar"></i> <?= format_date($tournament['start_date']) ?>
        </div>
        <div class="tournament-meta-item">
            <i class="fas fa-trophy"></i> <?= format_money($tournament['prize_pool']) ?>
        </div>
        <div class="tournament-meta-item">
            <i class="fas fa-users"></i> <?= escape($tournament['team_limit']) ?> Takım
        </div>
        <div class="tournament-meta-item">
            <i class="fas fa-sitemap"></i> <?= formatTournamentFormat($tournament['format']) ?>
        </div>
    </div>
    
    <div class="tournament-description">
        <?= nl2br(escape($tournament['description'])) ?>
    </div>
</div>

<div class="tournament-tabs">
    <div class="tab-nav">
        <div class="tab-nav-item active" data-tab="brackets">Turnuva Ağacı</div>
        <div class="tab-nav-item" data-tab="teams">Takımlar</div>
        <div class="tab-nav-item" data-tab="rules">Kurallar</div>
        <div class="tab-nav-item" data-tab="registration">Kayıt</div>
    </div>
    
    <div class="tab-content active" id="brackets-tab">
        <?php if ($tournament['status'] == 'draft' || $tournament['status'] == 'registration'): ?>
            <div class="alert alert-info">
                Turnuva henüz başlamadı. Eşleşmeler belirlendiğinde turnuva ağacı burada görüntülenecektir.
            </div>
        <?php elseif (empty($matches)): ?>
            <div class="alert alert-info">
                Henüz maç bilgisi bulunmamaktadır.
            </div>
        <?php else: ?>
            <div class="tournament-bracket">
                <div class="bracket-container">
                    <?php
                    // Tüm turları grupla
                    $roundMatches = [];
                    $maxRound = 0;
                    
                    foreach ($matches as $match) {
                        $round = $match['round'];
                        if (!isset($roundMatches[$round])) {
                            $roundMatches[$round] = [];
                        }
                        $roundMatches[$round][] = $match;
                        
                        if ($round > $maxRound) {
                            $maxRound = $round;
                        }
                    }
                    
                    // Her tur için
                    for ($round = 1; $round <= $maxRound; $round++): 
                        $roundName = $round == $maxRound ? 'Final' : 
                                     ($round == $maxRound - 1 ? 'Yarı Final' : 
                                     ($round == $maxRound - 2 ? 'Çeyrek Final' : 
                                     $round . '. Tur'));
                    ?>
                        <div class="bracket-round">
                            <div class="bracket-round-title"><?= $roundName ?></div>
                            
                            <?php if (isset($roundMatches[$round])): ?>
                                <?php foreach ($roundMatches[$round] as $match): ?>
                                    <div class="bracket-match">
                                        <div class="bracket-match-header">
                                            Maç #<?= $match['match_number'] ?>
                                            <?php if ($match['scheduled_at']): ?>
                                                - <?= format_date($match['scheduled_at']) ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="bracket-team <?= $match['winner_id'] == $match['team1_id'] ? 'winner' : ($match['loser_id'] == $match['team1_id'] ? 'loser' : '') ?>">
                                            <div class="bracket-team-name">
                                                <?php if ($match['team1_id']): ?>
                                                    <?php if ($match['team1_logo']): ?>
                                                        <img src="<?= url('/uploads/team_logos/' . $match['team1_logo']) ?>" alt="<?= escape($match['team1_name']) ?>" class="bracket-team-logo">
                                                    <?php endif; ?>
                                                    <?= escape($match['team1_name']) ?>
                                                <?php else: ?>
                                                    TBD
                                                <?php endif; ?>
                                            </div>
                                            <div class="bracket-team-score">
                                                <?= isset($match['score_team1']) ? $match['score_team1'] : '-' ?>
                                            </div>
                                        </div>
                                        
                                        <div class="bracket-team <?= $match['winner_id'] == $match['team2_id'] ? 'winner' : ($match['loser_id'] == $match['team2_id'] ? 'loser' : '') ?>">
                                            <div class="bracket-team-name">
                                                <?php if ($match['team2_id']): ?>
                                                    <?php if ($match['team2_logo']): ?>
                                                        <img src="<?= url('/uploads/team_logos/' . $match['team2_logo']) ?>" alt="<?= escape($match['team2_name']) ?>" class="bracket-team-logo">
                                                    <?php endif; ?>
                                                    <?= escape($match['team2_name']) ?>
                                                <?php else: ?>
                                                    TBD
                                                <?php endif; ?>
                                            </div>
                                            <div class="bracket-team-score">
                                                <?= isset($match['score_team2']) ? $match['score_team2'] : '-' ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bracket-match">
                                    <div class="bracket-match-header">Henüz Belirlenmedi</div>
                                    <div class="bracket-team">
                                        <div class="bracket-team-name">TBD</div>
                                        <div class="bracket-team-score">-</div>
                                    </div>
                                    <div class="bracket-team">
                                        <div class="bracket-team-name">TBD</div>
                                        <div class="bracket-team-score">-</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content" id="teams-tab">
        <?php if (empty($teams)): ?>
            <div class="alert alert-info">
                Henüz kayıtlı takım bulunmamaktadır.
            </div>
        <?php else: ?>
            <div class="team-list">
                <?php foreach ($teams as $team): ?>
                    <div class="team-list-item">
                        <?php if (!empty($team['logo'])): ?>
                            <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?>" class="team-list-logo">
                        <?php else: ?>
                            <div class="default-logo"><?= substr($team['name'], 0, 2) ?></div>
                        <?php endif; ?>
                        
                        <div class="team-list-info">
                            <h4 class="team-list-name"><?= escape($team['name']) ?></h4>
                            <div class="team-list-meta">
                                <?php if (isset($team['seed'])): ?>
                                    <span>Sıralama: <?= $team['seed'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="team-list-status status-<?= $team['registration_status'] ?>">
                            <?php 
                            $statusTexts = [
                                'pending' => 'Onay Bekliyor',
                                'approved' => 'Onaylandı',
                                'rejected' => 'Reddedildi'
                            ];
                            echo isset($statusTexts[$team['registration_status']]) ? $statusTexts[$team['registration_status']] : $team['registration_status'];
                            ?>
                        </div>
                        
                        <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="btn btn-sm btn-outline">Detaylar</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content" id="rules-tab">
        <?php if (empty($tournament['rules'])): ?>
            <div class="alert alert-info">
                Henüz detaylı kural bilgisi eklenmemiştir.
            </div>
        <?php else: ?>
            <div class="rules-content">
                <?= nl2br(escape($tournament['rules'])) ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content" id="registration-tab">
        <?php if ($tournament['status'] == 'registration'): ?>
            <?php if (Auth::isLoggedIn()): ?>
                <?php if ($isTeamRegistered): ?>
                    <div class="alert alert-success">
                        Takımınız bu turnuvaya zaten kayıtlıdır.
                    </div>
                <?php else: ?>
                    <?php if (!empty($userTeams)): ?>
                        <div class="registration-form">
                            <h3 class="form-title">Turnuvaya Kaydol</h3>
                            <form action="<?= url('/tournaments/register') ?>" method="post">
                                <input type="hidden" name="tournament_id" value="<?= $tournament['id'] ?>">
                                
                                <div class="form-group">
                                    <label for="team_id">Takımınızı Seçin:</label>
                                    <select name="team_id" id="team_id" class="form-control" required>
                                        <option value="">-- Takım Seçin --</option>
                                        <?php foreach ($userTeams as $team): ?>
                                            <option value="<?= $team['id'] ?>"><?= escape($team['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Kaydol</button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Turnuvaya kaydolmak için bir takıma sahip olmalısınız. 
                            <a href="<?= url('/teams') ?>" class="alert-link">Takım oluşturmak için tıklayın.</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="alert alert-info">
                    Turnuvaya kaydolmak için önce <a href="<?= url('/login') ?>" class="alert-link">giriş yapmalısınız</a>.
                </div>
            <?php endif; ?>
        <?php elseif ($tournament['status'] == 'draft'): ?>
            <div class="alert alert-info">
                Turnuva kayıtları henüz açılmamıştır. Kayıt tarihi: <?= format_date($tournament['registration_start']) ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                Bu turnuva için kayıtlar kapanmıştır.
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab değiştirme
    const tabNavItems = document.querySelectorAll('.tab-nav-item');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabNavItems.forEach(function(item) {
        item.addEventListener('click', function() {
            // Aktif tab nav
            tabNavItems.forEach(function(navItem) {
                navItem.classList.remove('active');
            });
            this.classList.add('active');
            
            // Aktif içerik
            const tabId = this.getAttribute('data-tab');
            tabContents.forEach(function(content) {
                content.classList.remove('active');
            });
            document.getElementById(tabId + '-tab').classList.add('active');
        });
    });
});
</script>