<!-- Edit listing (listings/edit.php) -->
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/teams/listings/view?id=' . $listing['id']) ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            İlana Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">İlanı Düzenle</h1>
            <p class="text-indigo-100 mt-2"><?= escape($team['name']) ?> takımı için ilanı güncelle</p>
        </div>
        
        <form action="<?= url('/teams/listings/update') ?>" method="post" class="p-8">
            <input type="hidden" name="id" value="<?= $listing['id'] ?>">
            
            <div class="space-y-6">
                <div>
                    <label for="team_id" class="block text-sm font-medium text-gray-700 mb-1">Takım:</label>
                    <input type="text" value="<?= escape($team['name']) ?>" class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg" disabled>
                </div>
                
                <div>
                    <label for="game_id" class="block text-sm font-medium text-gray-700 mb-1">Oyun:</label>
                    <select name="game_id" id="game_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">-- Oyun Seçin --</option>
                        <?php foreach ($games as $game): ?>
                            <option value="<?= $game['id'] ?>" data-slug="<?= $game['slug'] ?>" <?= $listing['game_id'] == $game['id'] ? 'selected' : '' ?>><?= escape($game['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">İlan Başlığı:</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($listing['title']) ?>" required>
                </div>
                
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Aranan Pozisyon:</label>
                    <select name="position" id="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">-- Pozisyon Seçin --</option>
                    </select>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">İlan Açıklaması:</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required><?= escape($listing['description']) ?></textarea>
                </div>
                
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Aranan Özellikler:</label>
                    <textarea name="requirements" id="requirements" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?= escape($listing['requirements']) ?></textarea>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">İlan Durumu:</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="active" <?= $listing['status'] == 'active' ? 'selected' : '' ?>>Aktif</option>
                        <option value="filled" <?= $listing['status'] == 'filled' ? 'selected' : '' ?>>Dolduruldu</option>
                        <option value="closed" <?= $listing['status'] == 'closed' ? 'selected' : '' ?>>Kapatıldı</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-8 pt-5 border-t border-gray-200">
                <div class="flex justify-between">
                    <form action="<?= url('/teams/listings/delete') ?>" method="post" onsubmit="return confirm('Bu ilanı silmek istediğinizden emin misiniz?');">
                        <input type="hidden" name="id" value="<?= $listing['id'] ?>">
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md shadow-sm text-sm font-medium hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            İlanı Sil
                        </button>
                    </form>
                    
                    <div>
                        <a href="<?= url('/teams/listings/view?id=' . $listing['id']) ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                            İptal
                        </a>
                        <button type="submit" class="inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Değişiklikleri Kaydet
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Game positions data from the controller
    const positionsData = <?= $positions ?>;
    const currentPosition = "<?= $listing['position'] ?>";
    
    const gameSelect = document.getElementById('game_id');
    const positionSelect = document.getElementById('position');
    
    if (gameSelect && positionSelect) {
        // Function to update positions based on selected game
        function updatePositions() {
            // Clear current options
            positionSelect.innerHTML = '';
            
            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Pozisyon Seçin --';
            positionSelect.appendChild(defaultOption);
            
            // Get selected game
            const selectedGame = gameSelect.options[gameSelect.selectedIndex];
            
            if (selectedGame && selectedGame.value) {
                const gameSlug = selectedGame.getAttribute('data-slug');
                const gamePositions = positionsData[gameSlug] || positionsData[selectedGame.text] || [];
                
                // Add positions for the selected game
                gamePositions.forEach(position => {
                    const option = document.createElement('option');
                    option.value = position;
                    option.textContent = position;
                    
                    // Select the current position if it matches
                    if (position === currentPosition) {
                        option.selected = true;
                    }
                    
                    positionSelect.appendChild(option);
                });
            }
        }
        
        // Update positions when the game changes
        gameSelect.addEventListener('change', updatePositions);
        
        // Initial update
        updatePositions();
    }
});
</script>