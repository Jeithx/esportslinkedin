<!-- Create player profile (player/create_profile.php) -->
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/player/profile') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Profilime Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <div class="flex items-center">
                <img src="<?= url('/assets/images/games/' . $game['slug'] . '.png') ?>" 
                     alt="<?= escape($game['name']) ?>" 
                     class="w-12 h-12 mr-4"
                     onerror="this.onerror=null; this.src='https://placehold.co/48x48/6d28d9/ffffff?text=<?= substr($game['name'], 0, 1) ?>';">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white"><?= escape($game['name']) ?> Profili Oluştur</h1>
                    <p class="text-indigo-100 mt-1">Takım başvurularında kullanılacak oyuncu bilgilerinizi girin</p>
                </div>
            </div>
        </div>
        
        <form action="<?= url('/player/profile/create') ?>" method="post" class="p-8">
            <input type="hidden" name="game_id" value="<?= $game['id'] ?>">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="rank" class="block text-sm font-medium text-gray-700 mb-1">Rank:</label>
                    <?php if (!empty($ranks)): ?>
                        <select name="rank" id="rank" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Rank Seçin</option>
                            <?php foreach ($ranks as $rank): ?>
                                <option value="<?= escape($rank) ?>"><?= escape($rank) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" name="rank" id="rank" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Örn: Gold, Platinum, vb.">
                    <?php endif; ?>
                </div>
                
                <div>
                    <label for="main_position" class="block text-sm font-medium text-gray-700 mb-1">Ana Pozisyon:</label>
                    <?php if (!empty($positions)): ?>
                        <select name="main_position" id="main_position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                            <option value="">Pozisyon Seçin</option>
                            <?php foreach ($positions as $position): ?>
                                <option value="<?= escape($position) ?>"><?= escape($position) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" name="main_position" id="main_position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Ana pozisyonunuz">
                    <?php endif; ?>
                </div>
                
                <div>
                    <label for="secondary_position" class="block text-sm font-medium text-gray-700 mb-1">İkinci Pozisyon (Opsiyonel):</label>
                    <?php if (!empty($positions)): ?>
                        <select name="secondary_position" id="secondary_position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Pozisyon Seçin</option>
                            <?php foreach ($positions as $position): ?>
                                <option value="<?= escape($position) ?>"><?= escape($position) ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <input type="text" name="secondary_position" id="secondary_position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="İkinci pozisyonunuz (opsiyonel)">
                    <?php endif; ?>
                </div>
                
                <div class="flex items-center h-full">
                    <label class="flex items-center">
                        <input type="checkbox" name="looking_for_team" value="1" class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <span class="ml-2 text-gray-700">Takım Arıyorum</span>
                    </label>
                </div>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Açıklama (Opsiyonel):</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Oyun deneyiminiz, başarılarınız, oyun tarzınız gibi bilgileri paylaşın"></textarea>
            </div>
            
            <div class="flex justify-end">
                <a href="<?= url('/player/profile') ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3">
                    İptal
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Profili Oluştur
                </button>
            </div>
        </form>
    </div>
    
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Oyuncu Profili İpuçları</h2>
        <ul class="space-y-3">
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Rank bilginizi doğru ve güncel olarak belirtin.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">En iyi olduğunuz pozisyonu ana pozisyon olarak seçin.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Açıklama kısmında oyun deneyiminizi, turnuva katılımlarınızı ve başarılarınızı belirtin.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Aktif olarak takım arıyorsanız "Takım Arıyorum" seçeneğini işaretleyin.</span>
            </li>
        </ul>
    </div>
</div>