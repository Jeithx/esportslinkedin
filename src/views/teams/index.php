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
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 flex items-center justify-center bg-gray-50">
                    <?php if (!empty($team['logo'])): ?>
                        <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" class="h-32 w-32 object-contain">
                    <?php else: ?>
                        <div class="h-24 w-24 rounded-full bg-indigo-600 text-white flex items-center justify-center text-3xl font-bold"><?= substr($team['name'], 0, 2) ?></div>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= escape($team['name']) ?></h3>
                    <p class="text-gray-600 mb-4 line-clamp-2"><?= escape($team['description']) ?></p>
                    <div class="flex items-center text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span><?= $team['member_count'] ?> Üye</span>
                    </div>
                    <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-block w-full text-center py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition duration-300">Takımı Görüntüle</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>