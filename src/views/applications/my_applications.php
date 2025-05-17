<!-- src/views/applications/my_applications.php (yeni dosya) -->
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/profile') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Profilime Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Başvurularım</h1>
            <p class="text-indigo-100 mt-2">Takım ilanlarına yaptığınız başvuruları yönetin</p>
        </div>
        
        <div class="p-6">
            <?php if (empty($applications)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz başvurunuz bulunmamaktadır</h3>
                    <p class="text-gray-600 mb-6">Takım ilanlarına başvurarak yeteneklerinizi gösterin ve takımlara katılın.</p>
                    <a href="<?= url('/teams/listings') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        İlanları Keşfet
                    </a>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($applications as $application): ?>
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex items-center">
                                    <?php if (!empty($application['team_logo'])): ?>
                                        <img src="<?= url('/uploads/team_logos/' . $application['team_logo']) ?>" alt="<?= escape($application['team_name']) ?>" class="w-12 h-12 rounded-full object-cover mr-4">
                                    <?php else: ?>
                                        <div class="w-12 h-12 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold">
                                            <?= strtoupper(substr($application['team_name'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div>
                                        <h3 class="font-bold text-lg"><?= escape($application['listing_title']) ?></h3>
                                        <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                            <span><?= escape($application['team_name']) ?></span>
                                            <span>•</span>
                                            <span><?= escape($application['game_name']) ?></span>
                                            <span>•</span>
                                            <span>Pozisyon: <?= escape($application['position']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex items-center">
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
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Başvuru Mesajınız:</h4>
                                    <div class="bg-gray-50 p-3 rounded-lg">
                                        <?= nl2br(escape($application['message'])) ?>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 mb-1">Başvuru Tarihi:</h4>
                                    <div class="text-gray-600"><?= format_date($application['created_at']) ?></div>
                                    
                                    <?php if ($application['status'] === 'pending'): ?>
                                        <div class="mt-4">
                                            <form action="<?= url('/applications/withdraw') ?>" method="post" onsubmit="return confirm('Bu başvuruyu geri çekmek istediğinize emin misiniz?');">
                                                <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                                                    Başvuruyu Geri Çek
                                                </button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between">
                                <a href="<?= url('/teams/view?id=' . $application['team_id']) ?>" class="text-indigo-600 hover:text-indigo-800">
                                    Takımı Görüntüle
                                </a>
                                <a href="<?= url('/teams/listings/view?id=' . $application['listing_id']) ?>" class="text-indigo-600 hover:text-indigo-800">
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