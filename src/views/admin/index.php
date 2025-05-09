<div class="admin-dashboard">
    <div class="stat-card primary">
        <div class="stat-label">Kullanıcılar</div>
        <div class="stat-value"><?= $userCount ?></div>
        <a href="<?= url('/admin/users') ?>" class="stat-link">Tümünü Görüntüle</a>
    </div>
    
    <div class="stat-card success">
        <div class="stat-label">Takımlar</div>
        <div class="stat-value"><?= $teamCount ?></div>
        <a href="<?= url('/admin/teams') ?>" class="stat-link">Tümünü Görüntüle</a>
    </div>
    
    <div class="stat-card warning">
        <div class="stat-label">Turnuvalar</div>
        <div class="stat-value"><?= $tournamentCount ?></div>
        <a href="<?= url('/admin/tournaments') ?>" class="stat-link">Tümünü Görüntüle</a>
    </div>
    
    <div class="stat-card danger">
        <div class="stat-label">Bekleyen Kayıtlar</div>
        <div class="stat-value"><?= $activeRegistrations ?></div>
    </div>
</div>

<div class="admin-section">
    <h2>Onay Bekleyen Takım Kayıtları</h2>
    
    <?php if (empty($pendingRegistrations)): ?>
        <div class="alert alert-info">Onay bekleyen kayıt bulunmamaktadır.</div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Takım</th>
                    <th>Turnuva</th>
                    <th>Kayıt Tarihi</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendingRegistrations as $registration): ?>
                    <tr>
                        <td><?= escape($registration['team_name']) ?></td>
                        <td><?= escape($registration['tournament_name']) ?></td>
                        <td><?= format_date($registration['created_at']) ?></td>
                        <td>
                            <div class="action-buttons">
                                <form action="<?= url('/admin/approve-registration') ?>" method="post" style="display:inline">
                                    <input type="hidden" name="registration_id" value="<?= $registration['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Onayla</button>
                                </form>
                                
                                <form action="<?= url('/admin/reject-registration') ?>" method="post" style="display:inline">
                                    <input type="hidden" name="registration_id" value="<?= $registration['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">Reddet</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<div class="admin-section">
    <h2>Son Kaydolan Kullanıcılar</h2>
    
    <?php if (empty($recentUsers)): ?>
        <div class="alert alert-info">Henüz kullanıcı kaydı bulunmamaktadır.</div>
    <?php else: ?>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Kullanıcı Adı</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Kayıt Tarihi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recentUsers as $user): ?>
                    <tr>
                        <td><?= escape($user['username']) ?></td>
                        <td><?= escape($user['email']) ?></td>
                        <td><?= $user['role'] == 'admin' ? 'Yönetici' : 'Kullanıcı' ?></td>
                        <td><?= format_date($user['created_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>