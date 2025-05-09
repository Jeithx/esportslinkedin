<div class="admin-header">
    <h1>Kullanıcı Yönetimi</h1>
</div>

<div class="admin-section">
    <h2>Kullanıcı Listesi</h2>
    
    <?php if (empty($users)): ?>
        <div class="alert alert-info">Henüz kullanıcı bulunmamaktadır.</div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kullanıcı Adı</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Kayıt Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= escape($user['username']) ?></td>
                        <td><?= escape($user['email']) ?></td>
                        <td>
                            <select class="user-role-select" data-user-id="<?= $user['id'] ?>">
                                <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>Kullanıcı</option>
                                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
                        </td>
                        <td><?= format_date($user['created_at']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="<?= url('/admin/users/edit?id=' . $user['id']) ?>" class="btn btn-sm btn-primary">Düzenle</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteUserModal" data-id="<?= $user['id'] ?>">
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

<!-- Kullanıcı Silme Modal -->
<div class="modal" id="deleteUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kullanıcıyı Sil</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            
            <div class="modal-body">
                <p>Bu kullanıcıyı silmek istediğinizden emin misiniz?</p>
                <p>Bu işlem geri alınamaz.</p>
                
                <form action="<?= url('/admin/delete-user') ?>" method="post">
                    <input type="hidden" name="user_id" id="delete_user_id">
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Kullanıcıyı Sil</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Kullanıcı Silme Modal
    const deleteUserModal = document.getElementById('deleteUserModal');
    if (deleteUserModal) {
        deleteUserModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const userId = button.getAttribute('data-id');
            document.getElementById('delete_user_id').value = userId;
        });
    }
    
    // Kullanıcı Rolü Değiştirme
    const roleSelects = document.querySelectorAll('.user-role-select');
    roleSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const role = this.value;
            
            // AJAX ile rolü güncelle
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= url('/admin/update-user-role') ?>', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Kullanıcı rolü başarıyla güncellendi.');
                        } else {
                            alert('Rol güncellenirken bir hata oluştu: ' + response.message);
                            // Değeri eski haline getir
                            this.value = this.getAttribute('data-original-value');
                        }
                    } catch (e) {
                        alert('Bir hata oluştu: ' + e.message);
                    }
                }
            }.bind(this);
            xhr.send('user_id=' + userId + '&role=' + role);
            
            // Mevcut değeri kaydet (hata durumunda geri dönmek için)
            this.setAttribute('data-original-value', role);
        });
    });
});
</script>