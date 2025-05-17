<!-- Listing index view (listings/index.php) -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Takım İlanları</h1>
                <p class="text-gray-600">Takımlarda açık pozisyonları keşfedin ve yeteneklerinizi gösterin</p>
            </div>
            
            <?php if (Auth::isLoggedIn()): ?>
                <a href="<?= url('/teams/listings/my-listings') ?>" class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    İlanlarımı Yönet
                </a>
            <?php endif; ?>
        </div>
        
        <!-- Filters -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <form action="<?= url('/teams/listings') ?>" method="get" class="flex flex-wrap gap-4 items-end">
                <div>
                    <label for="game_id" class="block text-sm font-medium text-gray-700 mb-1">Oyun:</label>
                    <select name="game_id" id="game_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tüm Oyunlar</option>
                        <?php foreach ($games as $game): ?>
                            <option value="<?= $game['id'] ?>" <?= $selectedGame == $game['id'] ? 'selected' : '' ?>>
                                <?= escape($game['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Pozisyon:</label>
                    <select name="position" id="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tüm Pozisyonlar</option>
                        <?php foreach ($positions as $game => $gamePositions): ?>
                            <optgroup label="<?= $game ?>">
                                <?php foreach ($gamePositions as $position): ?>
                                    <option value="<?= $position ?>" <?= $selectedPosition == $position ? 'selected' : '' ?>>
                                        <?= $position ?>
                                    </option>
                                <?php endforeach; ?>
                            </optgroup>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Filtrele
                    </button>
                    <?php if ($selectedGame || $selectedPosition): ?>
                        <a href="<?= url('/teams/listings') ?>" class="ml-2 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors">
                            Filtreleri Temizle
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Create listing button for team captains -->
        <?php if (Auth::isLoggedIn()): ?>
            <div class="mb-6">
                <a href="<?= url('/teams/listings/create') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Yeni İlan Oluştur
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Listings Grid -->
<?php if (empty($listings)): ?>
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-xl font-medium text-gray-800 mb-2">Şu anda aktif ilan bulunmamaktadır</h3>
        <p class="text-gray-600 mb-6">Daha sonra tekrar kontrol edin veya kendi takımınız için bir ilan oluşturun.</p>
        
        <?php if (Auth::isLoggedIn()): ?>
            <a href="<?= url('/teams/listings/create') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                İlk İlanı Oluştur
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($listings as $listing): ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                <div class="p-5 flex flex-col h-full">
                    <div class="flex items-center mb-4">
                        <?php if (!empty($listing['team_logo'])): ?>
                            <img src="<?= url('/uploads/team_logos/' . $listing['team_logo']) ?>" alt="<?= escape($listing['team_name']) ?> Logo" class="w-16 h-16 rounded-full object-cover mr-4">
                        <?php else: ?>
                            <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold text-xl">
                                <?= strtoupper(substr($listing['team_name'], 0, 2)) ?>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <h4 class="font-bold text-lg text-gray-800"><?= escape($listing['team_name']) ?></h4>
                            <div class="flex items-center mt-1">
                                <img src="<?= url('/assets/images/games/' . $listing['game_slug'] . '.png') ?>" 
                                    alt="<?= escape($listing['game_name']) ?>" 
                                    class="w-5 h-5 mr-1"
                                    onerror="this.onerror=null; this.src='https://placehold.co/20x20/6d28d9/ffffff?text=<?= substr($listing['game_name'], 0, 1) ?>';">
                                <span class="text-gray-600 text-sm"><?= escape($listing['game_name']) ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-2"><?= escape($listing['title']) ?></h3>
                    
                    <div class="mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            <?= escape($listing['position']) ?>
                        </span>
                    </div>
                    
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        <?= escape(substr($listing['description'], 0, 150)) ?><?= strlen($listing['description']) > 150 ? '...' : '' ?>
                    </p>
                    
                    <div class="mt-auto pt-4 flex justify-between items-center">
                        <span class="text-sm text-gray-500"><?= time_ago($listing['created_at']) ?></span>
                        <a href="<?= url('/teams/listings/view?id=' . $listing['id']) ?>" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                            Detayları Görüntüle
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter by game should update position options
    const gameSelect = document.getElementById('game_id');
    const positionSelect = document.getElementById('position');
    
    if (gameSelect && positionSelect) {
        // Store all original options
        const originalOptions = Array.from(positionSelect.options);
        
        gameSelect.addEventListener('change', function() {
            const selectedGame = gameSelect.options[gameSelect.selectedIndex].text;
            
            // Reset position dropdown
            positionSelect.innerHTML = '<option value="">Tüm Pozisyonlar</option>';
            
            // If a game is selected, filter positions
            if (gameSelect.value) {
                originalOptions.forEach(option => {
                    if (!option.value || option.parentNode.label === selectedGame) {
                        positionSelect.appendChild(option.cloneNode(true));
                    }
                });
            } else {
                // If no game selected, show all positions
                originalOptions.forEach(option => {
                    positionSelect.appendChild(option.cloneNode(true));
                });
            }
        });
    }
});
</script>