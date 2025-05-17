<!-- src/views/applications/team_applications.php (yeni dosya) -->
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <?= escape($team['name']) ?> Takımına Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white"><?= escape($team['name']) ?> - Başvurular</h1>
            <p class="text-indigo-100 mt-2">Takımınıza gelen başvuruları yönetin</p>
        </div>
        
        <div class="p-6">
            <?php if (empty($applications)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz başvuru bulunmamaktadır</h3>
                    <p class="text-gray-600 mb-6">Takımınız için ilan oluşturarak oyuncu başvurularını alabilirsiniz.</p>
                    <a href="<?= url('/teams/listings/create') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Yeni İlan Oluştur
                    </a>
                </div>
            <?php else: ?>
                <div class="mb-6 bg-indigo-50 p-4 rounded-lg border border-indigo-100">
                    <div class="flex items-center gap-2">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 text-sm">
                            <p>Bir oyuncuyu kabul ettiğinizde, oyuncu otomatik olarak takımınıza eklenecektir. Ayrıca, o pozisyon için başka oyuncu aramıyorsanız, ilanı "Dolduruldu" olarak işaretleyebilirsiniz.</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <?php foreach ($applications as $application): ?>
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                                <div class="flex items-start">
                                    <?php if (!empty($application['avatar'])): ?>
                                        <img src="<?= url('/uploads/avatars/' . $application['avatar']) ?>" alt="<?= escape($application['username']) ?>" class="w-16 h-16 rounded-full object-cover mr-4">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold text-xl">
                                            <?= strtoupper(substr($application['username'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div>
                                        <h3 class="font-bold text-lg"><?= escape($application['username']) ?></h3>
                                        <?php if (!empty($application['full_name'])): ?>
                                            <p class="text-gray-600"><?= escape($application['full_name']) ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($application['rank']) || !empty($application['main_position'])): ?>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <?php if (!empty($application['rank'])): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        Rank: <?= escape($application['rank']) ?>
                                                    </span>
                                                <?php endif; ?>
                                                
                                                <?php if (!empty($application['main_position'])): ?>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                        Pozisyon: <?= escape($application['main_position']) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Başvurduğu İlan:</h4>
                                    <p class="font-medium"><?= escape($application['listing_title']) ?></p>
                                    <p class="text-sm text-gray-600">
                                        <?= escape($application['game_name']) ?> - 
                                        <?= escape($application['position']) ?>
                                    </p>
                                    
                                    <div class="mt-2">
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
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-1">Başvuru Mesajı:</h4>
                                <div class="bg-gray-50 p-3 rounded-lg">
                                    <?= nl2br(escape($application['message'])) ?>
                                </div>
                            </div>
                            
                            <?php if ($application['status'] === 'pending'): ?>
                                <div class="mt-4 pt-4 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                                    <form action="<?= url('/applications/accept') ?>" method="post" class="flex-1">
                                        <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                                        <div class="flex items-center mb-2">
                                            <input type="checkbox" name="mark_as_filled" value="yes" id="mark-filled-<?= $application['id'] ?>" class="mr-2">
                                            <label for="mark-filled-<?= $application['id'] ?>" class="text-sm text-gray-600">İlanı dolduruldu olarak işaretle</label>
                                        </div>
                                        <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                            Kabul Et
                                        </button>
                                    </form>
                                    
                                    <form action="<?= url('/applications/reject') ?>" method="post" class="flex-1">
                                        <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                                        <div class="h-6 mb-2"></div> <!-- Boşluk -->
                                        <button type="submit" class="w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                            Reddet
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                            
                            <div class="mt-4 pt-1 text-right">
                                <a href="<?= url('/teams/listings/view?id=' . $application['listing_id']) ?>" class="text-indigo-600 hover:text-indigo-800 text-sm">
                                    İlanı Görüntüle
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>