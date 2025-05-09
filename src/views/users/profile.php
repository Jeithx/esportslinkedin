<div class="profile-container">
    <div class="profile-header">
        <?php if (!empty($user['avatar'])): ?>
            <img src="<?= url('/uploads/avatars/' . $user['avatar']) ?>" alt="<?= escape($user['username']) ?>" class="profile-avatar">
        <?php else: ?>
            <div class="default-avatar"><?= substr($user['username'], 0, 2) ?></div>
        <?php endif; ?>
        
        <div class="profile-info">
            <h1><?= escape($user['username']) ?></h1>
            <?php if (!empty($user['full_name'])): ?>
                <p class="profile-fullname"><?= escape($user['full_name']) ?></p>
            <?php endif; ?>
            
            <div class="profile-meta">
                <span>Üyelik: <?= format_date($user['created_at'], 'd.m.Y') ?></span>
                <?php if (!empty($user['game_id'])): ?>
                    <span>Oyuncu ID: <?= escape($user['game_id']) ?></span>
                <?php endif; ?>
                <?php if (!empty($user['discord'])): ?>
                    <span>Discord: <?= escape($user['discord']) ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="profile-tabs">
        <div class="tab-nav">
            <div class="tab-nav-item active" data-tab="teams">Takımlarım</div>
            <div class="tab-nav-item" data-tab="tournaments">Turnuvalarım</div>
            <div class="tab-nav-item" data-tab="settings">Profil Ayarları</div>
        </div>
        
        <div class="tab-content active" id="teams-tab">
            <h3>Takımlarım</h3>
            
            <?php if (empty($teams)): ?>
                <div class="alert alert-info">
                    Henüz bir takıma üye değilsiniz. 
                    <a href="<?= url('/teams') ?>" class="alert-link">Takım oluşturmak veya mevcut takımlara göz atmak için tıklayın.</a>
                </div>
            <?php else: ?>
                <div class="team-grid">
                    <?php foreach ($teams as $team): ?>
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
                                <div class="team-role <?= $team['team_role'] ?>"><?= $team['team_role'] == 'captain' ? 'Kaptan' : 'Üye' ?></div>
                                <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="btn btn-outline">Takımı Görüntüle</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="tab-content" id="tournaments-tab">
            <h3>Katıldığım Turnuvalar</h3>
            
            <?php if (empty($tournaments)): ?>
                <div class="alert alert-info">Henüz katıldığınız turnuva bulunmamaktadır.</div>
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
                            
                            <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-sm btn-outline">Turnuvayı Görüntüle</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="tab-content" id="settings-tab">
            <h3>Profil Ayarları</h3>
            
            <form action="<?= url('/profile/update') ?>" method="post" enctype="multipart/form-data" class="profile-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="username">Kullanıcı Adı:</label>
                        <input type="text" id="username" class="form-control" value="<?= escape($user['username']) ?>" disabled>
                        <small class="form-text text-muted">Kullanıcı adı değiştirilemez</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-posta:</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= escape($user['email']) ?>" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="full_name">Tam Ad:</label>
                    <input type="text" name="full_name" id="full_name" class="form-control" value="<?= escape($user['full_name'] ?? '') ?>">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="game_id">Oyuncu ID:</label>
                        <input type="text" name="game_id" id="game_id" class="form-control" value="<?= escape($user['game_id'] ?? '') ?>">
                        <small class="form-text text-muted">Oyun içi kullanıcı adınız veya hesap numaranız</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="discord">Discord:</label>
                        <input type="text" name="discord" id="discord" class="form-control" value="<?= escape($user['discord'] ?? '') ?>">
                        <small class="form-text text-muted">Discord kullanıcı adınız (örn: username#1234)</small>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="bio">Hakkımda:</label>
                    <textarea name="bio" id="bio" class="form-control" rows="3"><?= escape($user['bio'] ?? '') ?></textarea>
                </div>
                
                <div class="form-group">
                    <label>Mevcut Profil Resmi:</label>
                    <?php if (!empty($user['avatar'])): ?>
                        <div class="current-avatar">
                            <img src="<?= url('/uploads/avatars/' . $user['avatar']) ?>" alt="<?= escape($user['username']) ?>" style="max-width: 100px; max-height: 100px; border-radius: 50%;">
                        </div>
                    <?php else: ?>
                        <p>Profil resmi yok</p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="avatar">Yeni Profil Resmi Yükle:</label>
                    <input type="file" name="avatar" id="avatar" class="form-control-file" accept="image/*">
                    <small class="form-text text-muted">Önerilen: 500x500 piksel, PNG veya JPG formatında</small>
                </div>
                
                <hr class="my-4">
                
                <h4>Şifre Değiştir</h4>
                <div class="form-group">
                    <label for="current_password">Mevcut Şifre:</label>
                    <input type="password" name="current_password" id="current_password" class="form-control">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="new_password">Yeni Şifre:</label>
                        <input type="password" name="new_password" id="new_password" class="form-control">
                        <small class="form-text text-muted">En az 6 karakter</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password_confirm">Yeni Şifre Tekrar:</label>
                        <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control">
                    </div>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Profili Güncelle</button>
                </div>
            </form>
        </div>
    </div>
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

<style>
/* Profil Sayfası Stilleri */
.profile-container {
    max-width: 900px;
    margin: 0 auto;
}

.profile-header {
    display: flex;
    align-items: center;
    margin-bottom: 2rem;
}

.profile-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 2rem;
}

.default-avatar {
    width: 120px;
    height: 120px;
    background-color: var(--primary-color);
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: bold;
    text-transform: uppercase;
    margin-right: 2rem;
}

.profile-info {
    flex: 1;
}

.profile-info h1 {
    margin: 0 0 0.5rem 0;
}

.profile-fullname {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}

.profile-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    color: #6c757d;
    font-size: 0.9rem;
}

.profile-form {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

.form-row {
    display: flex;
    gap: 1rem;
}

.form-row .form-group {
    flex: 1;
}

.my-4 {
    margin-top: 2rem;
    margin-bottom: 2rem;
}

/* Tab stilleri yukarıdaki dosyalarda tanımlandı */

@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-avatar, .default-avatar {
        margin-right: 0;
        margin-bottom: 1.5rem;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
}
</style>

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