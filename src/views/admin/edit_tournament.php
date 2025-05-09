<div class="admin-header">
    <h1>Turnuva Düzenle: <?= escape($tournament['name']) ?></h1>
    <a href="<?= url('/admin/tournaments') ?>" class="btn btn-secondary">Turnuvalara Dön</a>
</div>

<div class="admin-form">
    <form action="<?= url('/admin/update-tournament') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $tournament['id'] ?>">
        
        <div class="form-group">
            <label for="name">Turnuva Adı:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= escape($tournament['name']) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="game_id">Oyun:</label>
            <select name="game_id" id="game_id" class="form-control" required>
                <option value="">-- Oyun Seçin --</option>
                <?php foreach ($games as $game): ?>
                    <option value="<?= $game['id'] ?>" <?= $tournament['game_id'] == $game['id'] ? 'selected' : '' ?>><?= escape($game['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="description">Turnuva Açıklaması:</label>
            <textarea name="description" id="description" class="form-control" rows="3"><?= escape($tournament['description']) ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="start_date">Başlangıç Tarihi:</label>
                <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($tournament['start_date'])) ?>" required>
            </div>
            
            <div class="form-group col-md-6">
                <label for="end_date">Bitiş Tarihi:</label>
                <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="<?= $tournament['end_date'] ? date('Y-m-d\TH:i', strtotime($tournament['end_date'])) : '' ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="registration_start">Kayıt Başlangıç:</label>
                <input type="datetime-local" name="registration_start" id="registration_start" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($tournament['registration_start'])) ?>" required>
            </div>
            
            <div class="form-group col-md-6">
                <label for="registration_end">Kayıt Bitiş:</label>
                <input type="datetime-local" name="registration_end" id="registration_end" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($tournament['registration_end'])) ?>" required>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="team_limit">Takım Limiti:</label>
                <input type="number" name="team_limit" id="team_limit" class="form-control" value="<?= $tournament['team_limit'] ?>" min="2" max="128" required>
            </div>
            
            <div class="form-group col-md-6">
                <label for="prize_pool">Ödül Havuzu (₺):</label>
                <input type="number" name="prize_pool" id="prize_pool" class="form-control" value="<?= $tournament['prize_pool'] ?>" min="0" step="0.01">
            </div>
        </div>
        
        <div class="form-group">
            <label for="format">Turnuva Formatı:</label>
            <select name="format" id="format" class="form-control" required>
                <option value="single_elimination" <?= $tournament['format'] == 'single_elimination' ? 'selected' : '' ?>>Tek Eleme</option>
                <option value="double_elimination" <?= $tournament['format'] == 'double_elimination' ? 'selected' : '' ?>>Çift Eleme</option>
                <option value="round_robin" <?= $tournament['format'] == 'round_robin' ? 'selected' : '' ?>>Lig Usulü</option>
                <option value="swiss" <?= $tournament['format'] == 'swiss' ? 'selected' : '' ?>>İsviçre Sistemi</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="rules">Turnuva Kuralları:</label>
            <textarea name="rules" id="rules" class="form-control" rows="5"><?= escape($tournament['rules']) ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Mevcut Banner:</label>
            <?php if (!empty($tournament['banner'])): ?>
                <div class="current-banner">
                    <img src="<?= url('/uploads/tournament_banners/' . $tournament['banner']) ?>" alt="<?= escape($tournament['name']) ?>" style="max-width: 300px;">
                </div>
            <?php else: ?>
                <p>Banner yok</p>
            <?php endif; ?>
        </div>
        
        <div class="form-group">
            <label for="banner">Yeni Banner Yükle:</label>
            <input type="file" name="banner" id="banner" class="form-control-file" accept="image/*">
            <small class="form-text text-muted">Önerilen: 1200x400 piksel, PNG veya JPG formatında</small>
        </div>
        
        <div class="form-group">
            <label for="status">Durum:</label>
            <select name="status" id="status" class="form-control" required>
                <option value="draft" <?= $tournament['status'] == 'draft' ? 'selected' : '' ?>>Taslak</option>
                <option value="registration" <?= $tournament['status'] == 'registration' ? 'selected' : '' ?>>Kayıt Açık</option>
                <option value="active" <?= $tournament['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                <option value="completed" <?= $tournament['status'] == 'completed' ? 'selected' : '' ?>>Tamamlandı</option>
                <option value="cancelled" <?= $tournament['status'] == 'cancelled' ? 'selected' : '' ?>>İptal Edildi</option>
            </select>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Turnuvayı Güncelle</button>
        </div>
    </form>
</div>