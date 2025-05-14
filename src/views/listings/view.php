<!-- Listing detail view (listings/view.php) -->
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/teams/listings') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            İlanlara Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
        <div class="flex flex-col md:flex-row">
            <!-- Team info sidebar -->
            <div class="md:w-1/3 bg-gray-50 p-6 flex flex-col items-center border-b md:border-b-0 md:border-r border-gray-200">
                <?php if (!empty($listing['team_logo'])): ?>
                    <img src="<?= url('/uploads/team_logos/' . $listing['team_logo']) ?>" alt="<?= escape($listing['team_name']) ?> Logo" class="w-28 h-28 object-contain mb-4">
                <?php else: ?>
                    <div class="w-28 h-28 bg-indigo-600 text-white flex items-center justify-center rounded-full mb-4 font-bold text-4xl">
                        <?= strtoupper(substr($listing['team_name'], 0, 2)) ?>
                    </div>
                <?php endif; ?>
                
                <h3 class="text-xl font-bold text-center mb-1"><?= escape($listing['team_name']) ?></h3>
                
                <div class="flex items-center mb-4">
                    <img src="<?= url('/assets/images/games/' . $listing['game_slug'] . '.png') ?>" 
                         alt="<?= escape($listing['game_name']) ?>" 
                         class="w-5 h-5 mr-1"
                         onerror="this.onerror=null; this.src='https://placehold.co/20x20/6d28d9/ffffff?text=<?= substr($listing['game_name'], 0, 1) ?>';">
                    <span class="text-gray-600"><?= escape($listing['game_name']) ?></span>
                </div>
                
                <a href="<?= url('/teams/view?id=' . $listing['team_id']) ?>" class="w-full text-center py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                    Takım Profilini Görüntüle
                </a>
                
                <div class="mt-6 w-full">
                    <h4 class="font-medium text-gray-700 mb-2">Takım Üyeleri</h4>
                    <div class="space-y-2">
                        <?php if (empty($teamMembers)): ?>
                            <p class="text-gray-500 text-sm">Henüz üye bulunmamaktadır.</p>
                        <?php else: ?>
                            <?php foreach ($teamMembers as $member): ?>
                                <div class="flex items-center bg-white p-2 rounded-lg shadow-sm">
                                    <?php if (!empty($member['avatar'])): ?>
                                        <img src="<?= url('/uploads/avatars/' . $member['avatar']) ?>" alt="<?= escape($member['username']) ?>" class="w-8 h-8 rounded-full mr-2">
                                    <?php else: ?>
                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium mr-2">
                                            <?= strtoupper(substr($member['username'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate"><?= escape($member['username']) ?></p>
                                    </div>
                                    
                                    <div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $member['team_role'] === 'captain' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' ?>">
                                            <?= $member['team_role'] === 'captain' ? 'Kaptan' : 'Üye' ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Listing details -->
            <div class="md:w-2/3 p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-2xl font-bold text-gray-800"><?= escape($listing['title']) ?></h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        <?= escape($listing['position']) ?>
                    </span>
                </div>
                
                <div class="text-sm text-gray-500 mb-6">
                    <?= time_ago($listing['created_at']) ?> yayınlandı
                </div>
                
                <div class="prose max-w-none mb-6">
                    <h3 class="text-lg font-semibold mb-2">İlan Açıklaması</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <?= nl2br(escape($listing['description'])) ?>
                    </div>
                </div>
                
                <?php if (!empty($listing['requirements'])): ?>
                    <div class="prose max-w-none mb-6">
                        <h3 class="text-lg font-semibold mb-2">Aranan Özellikler</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <?= nl2br(escape($listing['requirements'])) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Apply button / form -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <?php if (Auth::isLoggedIn()): ?>
                        <?php if ($isMember): ?>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                                <p class="text-gray-700">Zaten bu takımın üyesisiniz.</p>
                            </div>
                        <?php elseif ($hasApplied): ?>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                <p class="text-green-700">Bu ilana zaten başvurdunuz. Başvurunuzu <a href="<?= url('/applications/my-applications') ?>" class="text-indigo-600 hover:text-indigo-800 underline">Başvurularım</a> sayfasından takip edebilirsiniz.</p>
                            </div>
                        <?php elseif ($isCaptain): ?>
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                                <p class="text-gray-700">Bu ilan sizin takımınıza ait. <a href="<?= url('/teams/listings/edit?id=' . $listing['id']) ?>" class="text-indigo-600 hover:text-indigo-800 underline">Düzenle</a> veya <a href="<?= url('/applications/team-applications?team_id=' . $listing['team_id']) ?>" class="text-indigo-600 hover:text-indigo-800 underline">başvuruları görüntüle</a>.</p>
                            </div>
                        <?php elseif (!$hasGameProfile): ?>
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
                                <p class="text-yellow-700">Başvuru yapabilmek için <?= escape($listing['game_name']) ?> için bir oyuncu profili oluşturmalısınız.</p>
                                <a href="<?= url('/player/profile/create?game_id=' . $listing['game_id']) ?>" class="mt-2 inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                    Oyuncu Profili Oluştur
                                </a>
                            </div>
                        <?php else: ?>
                            <h3 class="text-lg font-semibold mb-4">Bu İlana Başvur</h3>
                            <form action="<?= url('/applications/apply') ?>" method="post" class="space-y-4">
                                <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Başvuru Mesajı:</label>
                                    <textarea name="message" id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required placeholder="Kendiniz, deneyimleriniz ve bu pozisyon için neden uygun olduğunuz hakkında bilgi verin"></textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="inline-flex justify-center px-6 py-2 border border-transparent rounded-lg shadow-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Başvuruyu Gönder
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-center">
                            <p class="text-blue-700 mb-2">Bu ilana başvurmak için giriş yapmalısınız.</p>
                            <a href="<?= url('/login') ?>" class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Giriş Yap
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Applications for team captain -->
                <?php if (isset($isCaptain) && $isCaptain && !empty($applications)): ?>
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Başvurular (<?= count($applications) ?>)</h3>
                        
                        <div class="space-y-4">
                            <?php foreach ($applications as $application): ?>
                                <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                                    <div class="p-4">
                                        <div class="flex items-center mb-3">
                                            <?php if (!empty($application['avatar'])): ?>
                                                <img src="<?= url('/uploads/avatars/' . $application['avatar']) ?>" alt="<?= escape($application['username']) ?>" class="w-10 h-10 rounded-full mr-3">
                                            <?php else: ?>
                                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-medium mr-3">
                                                    <?= strtoupper(substr($application['username'], 0, 2)) ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div>
                                                <h4 class="font-semibold"><?= escape($application['username']) ?></h4>
                                                <div class="text-sm text-gray-500">
                                                    <?= !empty($application['full_name']) ? escape($application['full_name']) . ' • ' : '' ?>
                                                    Başvuru: <?= time_ago($application['created_at']) ?>
                                                </div>
                                            </div>
                                            
                                            <div class="ml-auto">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    <?php 
                                                    $statusClasses = [
                                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                                        'accepted' => 'bg-green-100 text-green-800',
                                                        'rejected' => 'bg-red-100 text-red-800'
                                                    ];
                                                    $statusClass = isset($statusClasses[$application['status']]) ? $statusClasses[$application['status']] : 'bg-gray-100 text-gray-800';
                                                    echo $statusClass;
                                                    ?>">
                                                    <?php 
                                                    $statusTexts = [
                                                        'pending' => 'Bekliyor',
                                                        'accepted' => 'Kabul Edildi',
                                                        'rejected' => 'Reddedildi'
                                                    ];
                                                    echo isset($statusTexts[$application['status']]) ? $statusTexts[$application['status']] : $application['status'];
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <?php if (!empty($application['rank']) || !empty($application['main_position'])): ?>
                                            <div class="bg-indigo-50 rounded-lg p-2 mb-3 flex flex-wrap gap-2">
                                                <?php if (!empty($application['rank'])): ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        Rank: <?= escape($application['rank']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($application['main_position'])): ?>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        <?= escape($application['main_position']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <div class="bg-gray-50 p-3 rounded-lg mb-3">
                                            <h5 class="text-sm font-medium text-gray-700 mb-1">Başvuru Mesajı:</h5>
                                            <p class="text-gray-600"><?= nl2br(escape($application['message'])) ?></p>
                                        </div>
                                        
                                        <?php if ($application['status'] === 'pending'): ?>
                                            <div class="flex space-x-3 mt-3">
                                                <form action="<?= url('/applications/accept') ?>" method="post" class="flex-1">
                                                    <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                                                    <label class="flex items-center mb-2 text-sm text-gray-600">
                                                        <input type="checkbox" name="mark_as_filled" value="yes" class="h-4 w-4 text-indigo-600">
                                                        <span class="ml-2">İlanı dolduruldu olarak işaretle</span>
                                                    </label>
                                                    <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                                        Kabul Et
                                                    </button>
                                                </form>
                                                
                                                <form action="<?= url('/applications/reject') ?>" method="post" class="flex-1">
                                                    <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                                                    <div class="h-6 mb-2"></div> <!-- Spacer to align buttons -->
                                                    <button type="submit" class="w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                        Reddet
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="mt-4 text-right">
                            <a href="<?= url('/applications/team-applications?team_id=' . $listing['team_id']) ?>" class="text-indigo-600 hover:text-indigo-800">
                                Tüm başvuruları görüntüle →
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>