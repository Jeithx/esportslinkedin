<div class="admin-header">
    <h1>Takım Yönetimi</h1>
</div>

<div class="admin-section">
    <h2>Takım Listesi</h2>
    
    <?php if (empty($teams)): ?>
        <div class="alert alert-info">Henüz takım bulunmamaktadır.</div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Logo</th>
                    <th>Takım Adı</th>
                    <th>Kurucu</th>
                    <th>Üye Sayısı</th>
                    <th>Oluşturulma Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($teams as $team): ?>
                    <tr>
                        <td><?= $team['id'] ?></td>
                        <td>
                            <?php if (!empty($team['logo'])): ?>
                                <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?>" style="width: 40px; height: 40px; object-fit: contain;">
                            <?php else: ?>
                                <div class="default-logo" style="width: 40px; height: 40px; background-color: #6a3de8; color: white; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                    <?= substr($team['name'], 0, 2) ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?= escape($team['name']) ?></td>
                        <td><?= escape($team['owner_username']) ?></td>
                        <td><?= $team['member_count'] ?></td>
                        <td><?= format_date($team['created_at']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="btn btn-sm btn-info" target="_blank">Görüntüle</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteTeamModal" data-id="<?= $team['id'] ?>">
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

<!-- Takım Silme Modal -->
<div class="modal" id="deleteTeamModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Takımı Sil</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <p>Bu takımı silmek istediğinizden emin misiniz?</p>
                <p>Bu işlem geri alınamaz ve takımın tüm turnuva kayıtları da silinecektir.</p>
                
                <form action="<?= url('/admin/delete-team') ?>" method="post">
                    <input type="hidden" name="team_id" id="delete_team_id">
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Takımı Sil</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Takım Silme Modal
    const deleteTeamModal = document.getElementById('deleteTeamModal');
    if (deleteTeamModal) {
        deleteTeamModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const teamId = button.getAttribute('data-id');
            document.getElementById('delete_team_id').value = teamId;
        });
    }
});
</script>