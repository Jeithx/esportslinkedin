<div class="admin-header">
    <h1>Turnuva Yönetimi</h1>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTournamentModal">
        Yeni Turnuva Oluştur
    </button>
</div>

<div class="admin-section">
    <h2>Turnuva Listesi</h2>
    
    <?php if (empty($tournaments)): ?>
        <div class="alert alert-info">Henüz turnuva bulunmamaktadır.</div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Turnuva Adı</th>
                    <th>Oyun</th>
                    <th>Başlangıç Tarihi</th>
                    <th>Durum</th>
                    <th>Takım Sayısı</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tournaments as $tournament): ?>
                    <tr>
                        <td><?= $tournament['id'] ?></td>
                        <td><?= escape($tournament['name']) ?></td>
                        <td><?= escape($tournament['game_name']) ?></td>
                        <td><?= format_date($tournament['start_date']) ?></td>
                        <td>
                            <select class="tournament-status-select" data-tournament-id="<?= $tournament['id'] ?>">
                                <option value="draft" <?= $tournament['status'] == 'draft' ? 'selected' : '' ?>>Taslak</option>
                                <option value="registration" <?= $tournament['status'] == 'registration' ? 'selected' : '' ?>>Kayıt Açık</option>
                                <option value="active" <?= $tournament['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                                <option value="completed" <?= $tournament['status'] == 'completed' ? 'selected' : '' ?>>Tamamlandı</option>
                                <option value="cancelled" <?= $tournament['status'] == 'cancelled' ? 'selected' : '' ?>>İptal Edildi</option>
                            </select>
                        </td>
                        <td><?= $tournament['team_count'] ?> / <?= $tournament['team_limit'] ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="btn btn-sm btn-info" target="_blank">Görüntüle</a>
                                <a href="<?= url('/admin/tournaments/edit?id=' . $tournament['id']) ?>" class="btn btn-sm btn-primary">Düzenle</a>
                                <?php if ($tournament['status'] == 'active'): ?>
                                    <button type="button" class="btn btn-sm btn-secondary" id="generate-matches-btn" data-tournament-id="<?= $tournament['id'] ?>">
                                        Eşleşmeleri Oluştur
                                    </button>
                                <?php endif; ?>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteTournamentModal" data-id="<?= $tournament['id'] ?>">
                                    Sil
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Yeni Turnuva Oluşturma Modal -->
<div class="modal" id="createTournamentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Yeni Turnuva Oluştur</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <form action="<?= url('/admin/create-tournament') ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Turnuva Adı:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="game_id">Oyun:</label>
                        <select name="game_id" id="game_id" class="form-control" required>
                            <option value="">-- Oyun Seçin --</option>
                            <?php foreach ($games as $game): ?>
                                <option value="<?= $game['id'] ?>"><?= escape($game['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Turnuva Açıklaması:</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date">Başlangıç Tarihi:</label>
                            <input type="datetime-local" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="end_date">Bitiş Tarihi:</label>
                            <input type="datetime-local" name="end_date" id="end_date" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="registration_start">Kayıt Başlangıç:</label>
                            <input type="datetime-local" name="registration_start" id="registration_start" class="form-control" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="registration_end">Kayıt Bitiş:</label>
                            <input type="datetime-local" name="registration_end" id="registration_end" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="team_limit">Takım Limiti:</label>
                            <input type="number" name="team_limit" id="team_limit" class="form-control" value="16" min="2" max="128" required>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="prize_pool">Ödül Havuzu (₺):</label>
                            <input type="number" name="prize_pool" id="prize_pool" class="form-control" value="0" min="0" step="0.01">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="format">Turnuva Formatı:</label>
                        <select name="format" id="format" class="form-control" required>
                            <option value="single_elimination">Tek Eleme</option>
                            <option value="double_elimination">Çift Eleme</option>
                            <option value="round_robin">Lig Usulü</option>
                            <option value="swiss">İsviçre Sistemi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="rules">Turnuva Kuralları:</label>
                        <textarea name="rules" id="rules" class="form-control" rows="5"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="banner">Turnuva Banner:</label>
                        <input type="file" name="banner" id="banner" class="form-control-file" accept="image/*">
                        <small class="form-text text-muted">Önerilen: 1200x400 piksel, PNG veya JPG formatında</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Durum:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="draft">Taslak</option>
                            <option value="registration">Kayıt Açık</option>
                            <option value="active">Aktif</option>
                            <option value="completed">Tamamlandı</option>
                            <option value="cancelled">İptal Edildi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Turnuvayı Oluştur</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Turnuva Silme Modal -->
<div class="modal" id="deleteTournamentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Turnuvayı Sil</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <p>Bu turnuvayı silmek istediğinizden emin misiniz?</p>
                <p>Bu işlem geri alınamaz.</p>
                
                <form action="<?= url('/admin/delete-tournament') ?>" method="post">
                    <input type="hidden" name="tournament_id" id="delete_tournament_id">
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Turnuvayı Sil</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Turnuva Silme Modal
    const deleteTournamentModal = document.getElementById('deleteTournamentModal');
    if (deleteTournamentModal) {
        deleteTournamentModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const tournamentId = button.getAttribute('data-id');
            document.getElementById('delete_tournament_id').value = tournamentId;
        });
    }
    
    // Turnuva Durumu Değiştirme
    const statusSelects = document.querySelectorAll('.tournament-status-select');
    statusSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const tournamentId = this.getAttribute('data-tournament-id');
            const status = this.value;
            
            // AJAX ile durumu güncelle
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= url('/admin/update-tournament-status') ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Turnuva durumu başarıyla güncellendi.');
                        } else {
                            alert('Durum güncellenirken bir hata oluştu: ' + response.message);
                            // Değeri eski haline getir
                            this.value = this.getAttribute('data-original-value');
                        }
                    } catch (e) {
                        alert('Bir hata oluştu: ' + e.message);
                    }
                }
            }.bind(this);
            xhr.send('tournament_id=' + tournamentId + '&status=' + status);
            
            // Mevcut değeri kaydet (hata durumunda geri dönmek için)
            this.setAttribute('data-original-value', status);
        });
    });
    
    // Eşleşme oluşturma butonu
    const generateMatchesBtn = document.getElementById('generate-matches-btn');
    if (generateMatchesBtn) {
        generateMatchesBtn.addEventListener('click', function() {
            const tournamentId = this.getAttribute('data-tournament-id');
            
            if (confirm('Turnuva eşleşmelerini oluşturmak istediğinize emin misiniz?')) {
                // AJAX ile eşleşmeleri oluştur
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= url('/admin/generate-matches') ?>', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                alert('Turnuva eşleşmeleri başarıyla oluşturuldu.');
                                // Sayfayı yenile
                                window.location.reload();
                            } else {
                                alert('Eşleşmeler oluşturulurken bir hata oluştu: ' + response.message);
                            }
                        } catch (e) {
                            alert('Bir hata oluştu: ' + e.message);
                        }
                    }
                };
                xhr.send('tournament_id=' + tournamentId);
            }
        });
    }
});
</script>