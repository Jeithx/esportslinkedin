<div class="team-header">
    <div class="team-header-logo">
        <?php if (!empty($team['logo'])): ?>
            <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo">
        <?php else: ?>
            <div class="default-logo"><?= substr($team['name'], 0, 2) ?></div>
        <?php endif; ?>
    </div>
    
    <div class="team-header-info">
        <h1><?= escape($team['name']) ?></h1>
        <div class="team-meta">
            <span>Kurucu: <?= escape($team['owner_username']) ?></span>
            <span>Oluşturulma: <?= format_date($team['created_at']) ?></span>
        </div>
        
        <?php if ($isCaptain): ?>
            <div class="team-actions">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editTeamModal">Takımı Düzenle</a>
                <a href="#" class="btn btn-secondary" data-toggle="modal" data-target="#inviteModal">Üye Davet Et</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="team-description">
    <?= nl2br(escape($team['description'])) ?>
</div>

<div class="team-tabs">
    <div class="tab-nav">
        <div class="tab-nav-item active" data-tab="members">Üyeler</div>
        <div class="tab-nav-item" data-tab="tournaments">Turnuvalar</div>
        <?php if ($isCaptain): ?>
            <div class="tab-nav-item" data-tab="management">Takım Yönetimi</div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content active" id="members-tab">
        <h3>Takım Üyeleri</h3>
        
        <?php if (empty($members)): ?>
            <div class="alert alert-info">Henüz üye bulunmamaktadır.</div>
        <?php else: ?>
            <div class="member-list">
                <?php foreach ($members as $member): ?>
                    <div class="member-card">
                        <?php if (!empty($member['avatar'])): ?>
                            <img src="<?= url('/uploads/avatars/' . $member['avatar']) ?>" alt="<?= escape($member['username']) ?>" class="member-avatar">
                        <?php else: ?>
                            <div class="default-avatar"><?= substr($member['username'], 0, 2) ?></div>
                        <?php endif; ?>
                        
                        <div class="member-info">
                            <h4 class="member-name"><?= escape($member['username']) ?></h4>
                            <div class="member-role <?= $member['team_role'] ?>"><?= $member['team_role'] == 'captain' ? 'Kaptan' : 'Üye' ?></div>
                            <?php if (!empty($member['game_id'])): ?>
                                <div class="member-gameid">Oyuncu ID: <?= escape($member['game_id']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content" id="tournaments-tab">
        <h3>Katılım Sağlanan Turnuvalar</h3>
        
        <?php if (empty($tournaments)): ?>
            <div class="alert alert-info">Henüz turnuva katılımı bulunmamaktadır.</div>
        <?php else: ?>
            <div class="tournament-list">
                <?php foreach ($tournaments as $tournament): ?>
                    <div class="tournament-list-item">
                        <div class="tournament-list-info">
                            <h4 class="tournament-list-name"><?= escape($tournament['name']) ?></h4>
                            <div class="tournament-list-meta">
                                <span>Oyun: <?= escape($tournament['game_name']) ?></span>
                                <span>Tarih: <?= format_date($tournament['start_date']) ?></span>
                                <span>Durum: <?= formatTournamentStatus($tournament['status']) ?></span>
                            </div>
                        </div>
                        
                        <div class="tournament-list-status status-<?= $tournament['registration_status'] ?>">
                            <?php 
                            $statusTexts = [
                                'pending' => 'Onay Bekliyor',
                                'approved' => 'Onaylandı',
                                'rejected' => 'Reddedildi'
                            ];
                            echo isset($statusTexts[$tournament['registration_status']]) ? $statusTexts[$tournament['registration_status']] : $tournament['registration_status'];
                            ?>
                        </div>
                        
                        <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-sm btn-outline">Turnuvayı Görüntüle</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($isCaptain): ?>
        <div class="tab-content" id="management-tab">
            <h3>Takım Yönetimi</h3>
            
            <div class="team-management">
                <h4>Bekleyen Davetler</h4>
                
                <!-- Davetler listesi burada olacak -->
                <div class="pending-invites">
                    <!-- Örnek bir davet -->
                    <div class="invite-item">
                        <span>example@mail.com</span>
                        <div class="invite-actions">
                            <button class="btn btn-sm btn-danger">İptal Et</button>
                        </div>
                    </div>
                </div>
                
                <h4>Üye Davet Et</h4>
                <form action="<?= url('/teams/invite') ?>" method="post" class="invite-form">
                    <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                    
                    <div class="form-group flex-grow-1">
                        <input type="email" name="email" class="form-control" placeholder="E-posta adresi" required>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Davet Et</button>
                    </div>
                </form>
                
                <h4>Takım Ayarları</h4>
                <form action="<?= url('/teams/update') ?>" method="post" enctype="multipart/form-data" class="team-settings-form">
                    <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                    
                    <div class="form-group">
                        <label for="name">Takım Adı:</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= escape($team['name']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Takım Açıklaması:</label>
                        <textarea name="description" id="description" class="form-control" rows="3"><?= escape($team['description']) ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Mevcut Logo:</label>
                        <?php if (!empty($team['logo'])): ?>
                            <div class="current-logo">
                                <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" style="max-width: 200px; max-height: 200px;">
                            </div>
                        <?php else: ?>
                            <p>Logo yok</p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="logo">Yeni Logo Yükle:</label>
                        <input type="file" name="logo" id="logo" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Önerilen: 500x500 piksel, PNG veya JPG formatında</small>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Takımı Güncelle</button>
                    </div>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

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
    
    return isset($statuses[$status]) ? $statuses[$status] : $status;
}
?>

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