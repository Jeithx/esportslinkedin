<!-- Listing creation view (listings/create.php) -->
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
            <h1 class="text-2xl md:text-3xl font-bold text-white">Yeni Takım İlanı Oluştur</h1>
            <p class="text-indigo-100 mt-2">Takımınız için yeni oyuncu arayışınızı ilan edin</p>
        </div>
        
        <form action="<?= url('/teams/listings/create') ?>" method="post" class="p-8">
            <div class="space-y-6">
                <div>
                    <label for="team_id" class="block text-sm font-medium text-gray-700 mb-1">Takım:</label>
                    <select name="team_id" id="team_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">-- Takım Seçin --</option>
                        <?php foreach ($teams as $team): ?>
                            <option value="<?= $team['id'] ?>"><?= escape($team['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">İlanın hangi takım için olduğunu seçin (sadece kaptanı olduğunuz takımlar listelenir)</p>
                </div>
                
                <div>
                    <label for="game_id" class="block text-sm font-medium text-gray-700 mb-1">Oyun:</label>
                    <select name="game_id" id="game_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">-- Oyun Seçin --</option>
                        <?php foreach ($games as $game): ?>
                            <option value="<?= $game['id'] ?>" data-slug="<?= $game['slug'] ?>"><?= escape($game['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">İlan Başlığı:</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Örn: Valorant Takımımız için Duelist Arıyoruz">
                </div>
                
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Aranan Pozisyon:</label>
                    <select name="position" id="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <option value="">-- Önce Oyun Seçin --</option>
                    </select>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">İlan Açıklaması:</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Takımınız ve aradığınız oyuncu hakkında bilgi verin"></textarea>
                </div>
                
                <div>
                    <label for="requirements" class="block text-sm font-medium text-gray-700 mb-1">Aranan Özellikler:</label>
                    <textarea name="requirements" id="requirements" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Aradığınız oyuncuda olmasını istediğiniz özellikler (rank, yaş, deneyim vb.)"></textarea>
                </div>
            </div>
            
            <div class="mt-8 pt-5 border-t border-gray-200">
                <div class="flex justify-end">
                    <a href="<?= url('/teams/listings') ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        İptal
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        İlanı Yayınla
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">İlan Oluşturma İpuçları</h2>
        <ul class="space-y-3">
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">İlan başlığını açık ve çekici bir şekilde yazın.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Takımınız, hedefleriniz ve aradığınız oyuncu hakkında detaylı bilgi verin.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Aranan rank, deneyim ve diğer gereksinimleri belirterek doğru oyuncuları çekin.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Antrenman programı ve turnuva planınızdan bahsedin.</span>
            </li>
        </ul>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Game positions data from the controller
    const positionsData = <?= $positions ?>;
    
    const gameSelect = document.getElementById('game_id');
    const positionSelect = document.getElementById('position');
    
    if (gameSelect && positionSelect) {
        gameSelect.addEventListener('change', function() {
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
                    positionSelect.appendChild(option);
                });
            }
        });
    }
});
</script>