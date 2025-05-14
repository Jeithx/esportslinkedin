<!-- Player profile (player/profile.php) -->
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Oyuncu Profilim</h1>
            <p class="text-indigo-100 mt-2">Farklı oyunlar için oyuncu profillerinizi yönetin</p>
        </div>
        
        <div class="p-6">
            <div class="flex items-center mb-6">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?= url('/uploads/avatars/' . $user['avatar']) ?>" alt="<?= escape($user['username']) ?>" class="w-16 h-16 rounded-full object-cover mr-4">
                <?php else: ?>
                    <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 text-2xl font-bold">
                        <?= strtoupper(substr($user['username'], 0, 2)) ?>
                    </div>
                <?php endif; ?>
                
                <div>
                    <h2 class="text-xl font-bold text-gray-800"><?= escape($user['username']) ?></h2>
                    <?php if (!empty($user['full_name'])): ?>
                        <p class="text-gray-600"><?= escape($user['full_name']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if (empty($gameProfiles)): ?>
                <div class="bg-indigo-50 rounded-xl p-8 text-center border border-indigo-100 mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz oyun profili oluşturmadınız</h3>
                    <p class="text-gray-600 mb-4">Takım ilanlarına başvurabilmek için oyun profillerinizi oluşturun</p>
                </div>
            <?php else: ?>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Oyun Profillerim</h3>
                
                <div class="space-y-6 mb-8">
                    <?php foreach ($gameProfiles as $profile): ?>
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                            <div class="p-4 sm:p-6">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                                    <div class="flex items-center mb-3 sm:mb-0">
                                        <img src="<?= url('/assets/images/games/' . $profile['game_slug'] . '.png') ?>" 
                                             alt="<?= escape($profile['game_name']) ?>" 
                                             class="w-10 h-10 mr-3"
                                             onerror="this.onerror=null; this.src='https://placehold.co/40x40/6d28d9/ffffff?text=<?= substr($profile['game_name'], 0, 1) ?>';">
                                        <h4 class="text-xl font-bold text-gray-800"><?= escape($profile['game_name']) ?></h4>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?= $profile['looking_for_team'] ? 'green' : 'gray' ?>-100 text-<?= $profile['looking_for_team'] ? 'green' : 'gray' ?>-800">
                                            <?= $profile['looking_for_team'] ? 'Takım Arıyor' : 'Takım Aramıyor' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500 mb-1">Rank:</h5>
                                        <p class="text-gray-800 font-medium"><?= !empty($profile['rank']) ? escape($profile['rank']) : 'Belirtilmemiş' ?></p>
                                    </div>
                                    
                                    <div>
                                        <h5 class="text-sm font-medium text-gray-500 mb-1">Ana Pozisyon:</h5>
                                        <p class="text-gray-800 font-medium"><?= escape($profile['main_position']) ?></p>
                                    </div>
                                    
                                    <?php if (!empty($profile['secondary_position'])): ?>
                                        <div>
                                            <h5 class="text-sm font-medium text-gray-500 mb-1">İkinci Pozisyon:</h5>
                                            <p class="text-gray-800 font-medium"><?= escape($profile['secondary_position']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($profile['description'])): ?>
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium text-gray-500 mb-1">Açıklama:</h5>
                                        <div class="bg-gray-50 p-3 rounded-lg">
                                            <?= nl2br(escape($profile['description'])) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <button type="button" class="w-full py-2 text-center border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors"
                                            onclick="toggleProfileForm('<?= $profile['id'] ?>')">
                                        Profili Düzenle
                                    </button>
                                </div>
                                
                                <!-- Edit form (hidden by default) -->
                                <div id="edit-form-<?= $profile['id'] ?>" class="hidden mt-4 pt-4 border-t border-gray-200">
                                    <form action="<?= url('/player/profile/update') ?>" method="post">
                                        <input type="hidden" name="profile_id" value="<?= $profile['id'] ?>">
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="rank-<?= $profile['id'] ?>" class="block text-sm font-medium text-gray-700 mb-1">Rank:</label>
                                                <input type="text" name="rank" id="rank-<?= $profile['id'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($profile['rank']) ?>">
                                            </div>
                                            
                                            <div>
                                                <label for="main_position-<?= $profile['id'] ?>" class="block text-sm font-medium text-gray-700 mb-1">Ana Pozisyon:</label>
                                                <input type="text" name="main_position" id="main_position-<?= $profile['id'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($profile['main_position']) ?>" required>
                                            </div>
                                            
                                            <div>
                                                <label for="secondary_position-<?= $profile['id'] ?>" class="block text-sm font-medium text-gray-700 mb-1">İkinci Pozisyon:</label>
                                                <input type="text" name="secondary_position" id="secondary_position-<?= $profile['id'] ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($profile['secondary_position']) ?>">
                                            </div>
                                            
                                            <div>
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="looking_for_team" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?= $profile['looking_for_team'] ? 'checked' : '' ?>>
                                                    <span class="ml-2 text-sm text-gray-700">Takım Arıyorum</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label for="description-<?= $profile['id'] ?>" class="block text-sm font-medium text-gray-700 mb-1">Açıklama:</label>
                                            <textarea name="description" id="description-<?= $profile['id'] ?>" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?= escape($profile['description']) ?></textarea>
                                        </div>
                                        
                                        <div class="flex justify-end mt-4">
                                            <button type="button" class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 mr-3"
                                                    onclick="toggleProfileForm('<?= $profile['id'] ?>')">
                                                İptal
                                            </button>
                                            <button type="submit" class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Kaydet
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Create new profile section -->
            <?php if (!empty($availableGames)): ?>
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Yeni Oyun Profili Oluştur</h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        <?php foreach ($availableGames as $game): ?>
                            <a href="<?= url('/player/profile/create?game_id=' . $game['id']) ?>" class="bg-white border border-gray-200 rounded-lg p-4 flex flex-col items-center hover:shadow-md hover:border-indigo-300 transition-all">
                                <img src="<?= url('/assets/images/games/' . $game['slug'] . '.png') ?>" 
                                     alt="<?= escape($game['name']) ?>" 
                                     class="w-16 h-16 mb-2"
                                     onerror="this.onerror=null; this.src='https://placehold.co/64x64/6d28d9/ffffff?text=<?= substr($game['name'], 0, 1) ?>';">
                                <span class="text-center font-medium text-gray-800"><?= escape($game['name']) ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function toggleProfileForm(profileId) {
    const form = document.getElementById('edit-form-' + profileId);
    form.classList.toggle('hidden');
}
</script>