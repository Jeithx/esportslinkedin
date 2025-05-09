<div class="page-header">
    <h1>Takımlar</h1>
    <p>Tüm kayıtlı takımlar</p>
</div>

<?php if (Auth::isLoggedIn()): ?>
    <div class="create-team-section">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTeamModal">
            Yeni Takım Oluştur
        </button>
    </div>
    
    <!-- Takım Oluşturma Modal -->
    <div class="modal" id="createTeamModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Yeni Takım Oluştur</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                </div>
                
                <div class="modal-body">
                    <form action="<?= url('/teams/create') ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Takım Adı:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Takım Açıklaması:</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="logo">Takım Logosu:</label>
                            <input type="file" name="logo" id="logo" class="form-control-file" accept="image/*">
                            <small class="form-text text-muted">Önerilen: 500x500 piksel, PNG veya JPG formatında</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Takımı Oluştur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (empty($teams)): ?>
    <div class="alert alert-info">Henüz kayıtlı takım bulunmamaktadır.</div>
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
                    <p><?= escape($team['description']) ?></p>
                    <div class="team-meta">
                        <span><?= $team['member_count'] ?> Üye</span>
                    </div>
                    <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="btn btn-outline">Takımı Görüntüle</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>