<!-- src/views/listings/my_listings.php -->
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/teams/listings') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            İlanlara Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">İlanlarım</h1>
            <p class="text-indigo-100 mt-2">Takımlarınız için oluşturduğunuz ilanları yönetin</p>
        </div>
        
        <div class="p-6">
            <div class="flex flex-wrap gap-4 mb-6">
                <a href="<?= url('/teams/listings/create') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Yeni İlan Oluştur
                </a>
            </div>
            
            <?php if (empty($listings)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz ilan oluşturmadınız</h3>
                    <p class="text-gray-600 mb-6">Takımınız için yeni oyuncular arıyorsanız ilan oluşturun</p>
                    <a href="<?= url('/teams/listings/create') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        İlk İlanı Oluştur
                    </a>
                </div>
            <?php else: ?>
                <?php if (!empty($teams)): ?>
                    <div class="mb-6">
                        <label for="team_filter" class="block text-sm font-medium text-gray-700 mb-2">Takıma Göre Filtrele:</label>
                        <select id="team_filter" class="w-full sm:w-auto px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Tüm Takımlar</option>
                            <?php foreach ($teams as $team): ?>
                                <option value="<?= $team['id'] ?>"><?= escape($team['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
                
                <div class="space-y-6 listing-container">
                    <?php foreach ($listings as $listing): ?>
                        <div class="bg-white rounded-lg shadow border border-gray-200 overflow-hidden listing-item" data-team-id="<?= $listing['team_id'] ?>">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
                                    <div class="flex items-center">
                                        <?php if (!empty($listing['team_logo'])): ?>
                                            <img src="<?= url('/uploads/team_logos/' . $listing['team_logo']) ?>" alt="<?= escape($listing['team_name']) ?>" class="w-12 h-12 rounded-full object-cover mr-4">
                                        <?php else: ?>
                                            <div class="w-12 h-12 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold">
                                                <?= strtoupper(substr($listing['team_name'], 0, 2)) ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div>
                                            <h3 class="font-bold text-lg text-gray-800"><?= escape($listing['title']) ?></h3>
                                            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                                                <span><?= escape($listing['team_name']) ?></span>
                                                <span>•</span>
                                                <span><?= escape($listing['game_name']) ?></span>
                                                <span>•</span>
                                                <span>Pozisyon: <?= escape($listing['position']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            <?php 
                                            $statusClasses = [
                                                'active' => 'bg-green-100 text-green-800',
                                                'filled' => 'bg-blue-100 text-blue-800',
                                                'closed' => 'bg-gray-100 text-gray-800'
                                            ];
                                            $statusClass = isset($statusClasses[$listing['status']]) ? $statusClasses[$listing['status']] : 'bg-gray-100 text-gray-800';
                                            echo $statusClass;
                                            ?>">
                                            <?php 
                                            $statusTexts = [
                                                'active' => 'Aktif',
                                                'filled' => 'Dolduruldu',
                                                'closed' => 'Kapatıldı'
                                            ];
                                            echo isset($statusTexts[$listing['status']]) ? $statusTexts[$listing['status']] : $listing['status'];
                                            ?>
                                        </span>
                                        
                                        <?php if ($listing['pending_applications'] > 0): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                <?= $listing['pending_applications'] ?> Bekleyen Başvuru
                                            </span>
                                        <?php endif; ?>
                                        
                                        <span class="text-sm text-gray-500"><?= time_ago($listing['created_at']) ?></span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap md:justify-end gap-2 mt-4 pt-4 border-t border-gray-200">
                                    <a href="<?= url('/teams/listings/view?id=' . $listing['id']) ?>" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                                        İlanı Görüntüle
                                    </a>
                                    <a href="<?= url('/teams/listings/edit?id=' . $listing['id']) ?>" class="px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                                        Düzenle
                                    </a>
                                    <a href="<?= url('/applications/team-applications?team_id=' . $listing['team_id']) ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                        Başvuruları Yönet
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Takım filtreleme
    const teamFilter = document.getElementById('team_filter');
    const listingItems = document.querySelectorAll('.listing-item');
    
    if (teamFilter) {
        teamFilter.addEventListener('change', function() {
            const selectedTeamId = this.value;
            
            listingItems.forEach(function(item) {
                const teamId = item.getAttribute('data-team-id');
                
                if (!selectedTeamId || teamId === selectedTeamId) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    }
});
</script>