<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
    <div class="p-6 flex flex-col md:flex-row items-center md:items-start">
        <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
            <?php if (!empty($team['logo'])): ?>
                <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" class="w-32 h-32 object-contain">
            <?php else: ?>
                <div class="w-32 h-32 rounded-full bg-indigo-600 text-white flex items-center justify-center text-4xl font-bold">
                    <?= substr($team['name'], 0, 2) ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-800 mb-2"><?= escape($team['name']) ?></h1>
            <div class="text-gray-600 mb-4 flex flex-wrap justify-center md:justify-start gap-4">
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Kurucu: <?= escape($team['owner_username']) ?>
                </span>
                <span class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Oluşturulma: <?= format_date($team['created_at']) ?>
                </span>
            </div>
            
            <?php if ($isCaptain): ?>
                <div class="flex gap-2 justify-center md:justify-start">
                    <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition" data-toggle="modal" data-target="#editTeamModal">Takımı Düzenle</a>
                    <a href="#" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition" data-toggle="modal" data-target="#inviteModal">Üye Davet Et</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php if (!empty($team['description'])): ?>
        <div class="px-6 py-4 border-t border-gray-100">
            <div class="text-gray-700"><?= nl2br(escape($team['description'])) ?></div>
        </div>
    <?php endif; ?>
</div>

<?php if ($isCaptain): ?>
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Takıma Üye Davet Et</h3>
        
        <form action="<?= url('/teams/invite') ?>" method="post" class="space-y-4">
            <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Davet Edilecek E-posta:</label>
                <div class="flex">
                    <input type="email" name="email" id="email" class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-r-lg hover:bg-indigo-700 transition-colors">
                        Davet Gönder
                    </button>
                </div>
                <p class="mt-1 text-sm text-gray-500">Davet gönderilecek kişinin e-posta adresini girin.</p>
            </div>
        </form>
        
        <div class="mt-4">
            <a href="<?= url('/teams/pending-invitations?team_id=' . $team['id']) ?>" class="text-sm text-indigo-600 hover:text-indigo-800">
                Bekleyen Davetleri Görüntüle →
            </a>
        </div>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="flex border-b border-gray-200">
        <button class="tab-nav-item active px-6 py-3 font-medium text-gray-700 border-b-2 border-indigo-600 focus:outline-none" data-tab="members">Üyeler</button>
        <button class="tab-nav-item px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="tournaments">Turnuvalar</button>
        <?php if ($isCaptain): ?>
            <button class="tab-nav-item px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="management">Takım Yönetimi</button>
        <?php endif; ?>
    </div>
    
    <div class="tab-content active p-6" id="members-tab">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Takım Üyeleri</h3>
        
        <?php if (empty($members)): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">Henüz üye bulunmamaktadır.</div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($members as $member): ?>
                    <div class="bg-white rounded-lg shadow p-4 border border-gray-100 flex items-center">
                        <?php if (!empty($member['avatar'])): ?>
                            <img src="<?= url('/uploads/avatars/' . $member['avatar']) ?>" alt="<?= escape($member['username']) ?>" class="w-16 h-16 rounded-full object-cover mr-4">
                        <?php else: ?>
                            <div class="w-16 h-16 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-xl font-bold mr-4">
                                <?= substr($member['username'], 0, 2) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <h4 class="text-lg font-bold"><?= escape($member['username']) ?></h4>
                            <div class="<?= $member['team_role'] == 'captain' ? 'text-indigo-600 font-semibold' : 'text-gray-500' ?>">
                                <?= $member['team_role'] == 'captain' ? 'Kaptan' : 'Üye' ?>
                            </div>
                            <?php if (!empty($member['game_id'])): ?>
                                <div class="text-sm text-gray-600 mt-1">Oyuncu ID: <?= escape($member['game_id']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content hidden p-6" id="tournaments-tab">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Katılım Sağlanan Turnuvalar</h3>
        
        <?php if (empty($tournaments)): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">Henüz turnuva katılımı bulunmamaktadır.</div>
        <?php else: ?>
            <div class="space-y-4">
                <?php foreach ($tournaments as $tournament): ?>
                    <div class="bg-white rounded-lg shadow p-4 border border-gray-100 flex flex-col md:flex-row md:items-center justify-between">
                        <div class="mb-3 md:mb-0">
                            <h4 class="text-lg font-bold"><?= escape($tournament['name']) ?></h4>
                            <div class="flex flex-wrap gap-2 text-sm text-gray-600 mt-1">
                                <span>Oyun: <?= escape($tournament['game_name']) ?></span>
                                <span>•</span>
                                <span>Tarih: <?= format_date($tournament['start_date']) ?></span>
                                <span>•</span>
                                <span>Durum: <?= formatTournamentStatus($tournament['status']) ?></span>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php 
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800'
                            ];
                            $statusClass = isset($statusClasses[$tournament['registration_status']]) ? $statusClasses[$tournament['registration_status']] : 'bg-gray-100 text-gray-800';
                            echo $statusClass;
                            ?>">
                                <?php 
                                $statusTexts = [
                                    'pending' => 'Onay Bekliyor',
                                    'approved' => 'Onaylandı',
                                    'rejected' => 'Reddedildi'
                                ];
                                echo isset($statusTexts[$tournament['registration_status']]) ? $statusTexts[$tournament['registration_status']] : $tournament['registration_status'];
                                ?>
                            </span>
                            
                            <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="inline-flex items-center px-3 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition text-sm">
                                Turnuvayı Görüntüle
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if ($isCaptain): ?>
        <div class="tab-content hidden p-6" id="management-tab">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Takım Yönetimi</h3>
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold mb-3">Üye Davet Et</h4>
                <form action="<?= url('/teams/invite') ?>" method="post" class="flex flex-col md:flex-row gap-3 mb-6">
                    <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                    
                    <div class="flex-grow">
                        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="E-posta adresi" required>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full md:w-auto px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Davet Et</button>
                    </div>
                </form>
                
                <h4 class="text-lg font-semibold mb-3">Bekleyen Davetler</h4>
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <!-- Davetler listesi -->
                    <div class="flex justify-between items-center py-2 border-b border-gray-200 last:border-0">
                        <span class="text-gray-700">example@mail.com</span>
                        <button class="px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition">İptal Et</button>
                    </div>
                </div>
                
                <h4 class="text-lg font-semibold mb-3">Takım Ayarları</h4>
                <form action="<?= url('/teams/update') ?>" method="post" enctype="multipart/form-data" class="space-y-4">
                    <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                    
                    <div>
                        <label for="name" class="block text-gray-700 font-medium mb-2">Takım Adı:</label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" value="<?= escape($team['name']) ?>" required>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-gray-700 font-medium mb-2">Takım Açıklaması:</label>
                        <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3"><?= escape($team['description']) ?></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Mevcut Logo:</label>
                        <?php if (!empty($team['logo'])): ?>
                            <div class="mt-2 mb-3">
                                <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" class="max-w-xs max-h-40 object-contain">
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500 italic">Logo yok</p>
                        <?php endif; ?>
                    </div>
                    
                    <div>
                        <label for="logo" class="block text-gray-700 font-medium mb-2">Yeni Logo Yükle:</label>
                        <input type="file" name="logo" id="logo" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" accept="image/*">
                        <small class="text-gray-500 mt-1 block">Önerilen: 500x500 piksel, PNG veya JPG formatında</small>
                    </div>
                    
                    <div>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Takımı Güncelle</button>
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
                navItem.classList.remove('border-b-2');
                navItem.classList.remove('border-indigo-600');
                navItem.classList.remove('text-gray-700');
                navItem.classList.add('text-gray-500');
            });
            this.classList.add('active');
            this.classList.add('border-b-2');
            this.classList.add('border-indigo-600');
            this.classList.add('text-gray-700');
            
            // Aktif içerik
            const tabId = this.getAttribute('data-tab');
            tabContents.forEach(function(content) {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            const activeTab = document.getElementById(tabId + '-tab');
            activeTab.classList.remove('hidden');
            activeTab.classList.add('active');
        });
    });
});
</script>