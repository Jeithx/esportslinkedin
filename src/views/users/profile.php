
<!-- src/views/users/profile.php -->
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Profil Başlığı -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-32 md:h-48"></div>
        <div class="px-6 py-4 md:px-8 md:py-6 flex flex-col md:flex-row md:items-end -mt-16 relative z-10">
            <!-- Profil Fotoğrafı -->
            <div class="flex-shrink-0 mb-4 md:mb-0 md:mr-6">
                <?php if (!empty($user['avatar'])): ?>
                    <img src="<?= url('/uploads/avatars/' . $user['avatar']) ?>" alt="<?= escape($user['username']) ?>" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover">
                <?php else: ?>
                    <div class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-600 to-indigo-800 border-4 border-white shadow-md flex items-center justify-center text-white text-4xl font-bold">
                        <?= strtoupper(substr($user['username'], 0, 2)) ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Kullanıcı Bilgileri -->
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-gray-900 mb-1"><?= escape($user['username']) ?></h1>
                <?php if (!empty($user['full_name'])): ?>
                    <p class="text-lg text-gray-700 mb-3"><?= escape($user['full_name']) ?></p>
                <?php endif; ?>
                
                <div class="flex flex-wrap gap-3 text-gray-600 text-sm mb-4">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Üyelik: <?= format_date($user['created_at'], 'd.m.Y') ?></span>
                    </div>
                    
                    <?php if (!empty($user['game_id'])): ?>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>Oyuncu ID: <?= escape($user['game_id']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['discord'])): ?>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189Z"/>
                            </svg>
                            <span>Discord: <?= escape($user['discord']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Rol: <?= $user['role'] === 'admin' ? 'Yönetici' : 'Kullanıcı' ?></span>
                    </div>
                </div>
                
                <?php if (!empty($user['bio'])): ?>
                    <div class="text-gray-700 mb-4">
                        <?= nl2br(escape($user['bio'])) ?>
                    </div>
                <?php endif; ?>

                
                <?php
                // Bekleyen davetleri kontrol et
                // $userEmail = Session::get('user_email');
                // $pendingInvitations = $database->fetch(
                //     "SELECT COUNT(*) as count FROM team_invitations 
                //     WHERE recipient_email = ? AND status = 'pending' AND expires_at > NOW()",
                //     [$userEmail]
                // );

                // $pendingInvitationCount = $pendingInvitations ? $pendingInvitations['count'] : 0;
                if ($pendingInvitationCount > 0):
                ?>
                    <div class="mt-4 bg-blue-50 text-blue-800 p-3 rounded-lg text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <span class="font-semibold"><?= $pendingInvitationCount ?> bekleyen takım davetiniz</span> var.
                            <a href="<?= url('/teams/invitations') ?>" class="underline hover:text-blue-900">Görüntülemek için tıklayın</a>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sekmeler -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="flex border-b border-gray-200 overflow-x-auto">
            <button class="tab-nav-item active px-6 py-3 font-medium text-gray-700 border-b-2 border-indigo-600 focus:outline-none" data-tab="teams">Takımlarım</button>
            <button class="tab-nav-item px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="tournaments">Turnuvalarım</button>
            <button class="tab-nav-item px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="settings">Profil Ayarları</button>
        </div>
        
        <!-- Takımlarım Sekmesi -->
        <div class="tab-content active p-6" id="teams-tab">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Takımlarım</h3>
                <a href="<?= url('/teams/create') ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Yeni Takım
                </a>
            </div>
            
            <?php if (empty($teams)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz bir takıma üye değilsiniz</h3>
                    <p class="text-gray-600 mb-6">Kendi e-spor takımınızı kurabilir veya mevcut takımlara katılabilirsiniz</p>
                    <a href="<?= url('/teams') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Takımları Keşfet
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($teams as $team): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                            <div class="p-5 flex flex-col h-full">
                                <div class="flex items-center mb-4">
                                    <?php if (!empty($team['logo'])): ?>
                                        <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" class="w-16 h-16 rounded-full object-cover mr-4">
                                    <?php else: ?>
                                        <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold text-xl">
                                            <?= strtoupper(substr($team['name'], 0, 2)) ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div>
                                        <h4 class="font-bold text-lg text-gray-800"><?= escape($team['name']) ?></h4>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            <?= $team['team_role'] === 'captain' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' ?>">
                                            <?= $team['team_role'] === 'captain' ? 'Kaptan' : 'Üye' ?>
                                        </span>
                                    </div>
                                </div>
                                
                                <?php if ($team['team_role'] === 'captain'): ?>
                                    <div class="bg-green-50 text-green-800 rounded-lg p-3 mb-4 text-sm flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        <p>Bu takımın kaptanısınız. Takımı yönetebilir ve turnuvalara kaydedebilirsiniz.</p>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="mt-auto">
                                    <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="block w-full text-center py-2 bg-indigo-50 text-indigo-600 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                                        Takımı Görüntüle
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Turnuvalarım Sekmesi -->
        <div class="tab-content hidden p-6" id="tournaments-tab">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-800">Katıldığım Turnuvalar</h3>
                <a href="<?= url('/tournaments') ?>" class="inline-flex items-center px-4 py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Tüm Turnuvalar
                </a>
            </div>
            
            <?php if (empty($tournaments)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz turnuvalara katılmadınız</h3>
                    <p class="text-gray-600 mb-6">Takımınızla turnuvalara katılarak yeteneklerinizi gösterin ve ödüller kazanın</p>
                    <a href="<?= url('/tournaments') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Turnuvalara Göz At
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php foreach ($tournaments as $tournament): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 border border-gray-100">
                            <div class="h-24 <?php 
                                $bgColors = [
                                    'draft' => 'bg-gray-500',
                                    'registration' => 'bg-blue-600',
                                    'active' => 'bg-green-600',
                                    'completed' => 'bg-purple-600',
                                    'cancelled' => 'bg-red-600'
                                ];
                                $bgColor = isset($bgColors[$tournament['status']]) ? $bgColors[$tournament['status']] : 'bg-indigo-600';
                                echo $bgColor;
                            ?> relative">
                                <div class="absolute inset-0 bg-opacity-75 flex items-center justify-center">
                                    <img src="<?= url('/assets/images/games/' . strtolower($tournament['game_slug'] ?? $tournament['slug'] ?? 'game') . '.png') ?>" 
                                        alt="<?= escape($tournament['game_name']) ?>" 
                                        class="h-16 opacity-75"
                                        onerror="this.onerror=null; this.src='https://placehold.co/64x64/6d28d9/ffffff?text=<?= substr($tournament['game_name'], 0, 1) ?>';">
                                </div>
                            </div>
                            
                            <div class="p-5">
                                <div class="flex justify-between items-start mb-4">
                                    <h4 class="font-bold text-lg text-gray-800"><?= escape($tournament['name']) ?></h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?php 
                                        $statusClasses = [
                                            'draft' => 'bg-gray-100 text-gray-800',
                                            'registration' => 'bg-blue-100 text-blue-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'completed' => 'bg-purple-100 text-purple-800',
                                            'cancelled' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusClass = isset($statusClasses[$tournament['status']]) ? $statusClasses[$tournament['status']] : 'bg-gray-100 text-gray-800';
                                        echo $statusClass;
                                        ?>">
                                        <?= formatTournamentStatus($tournament['status']) ?>
                                    </span>
                                </div>
                                
                                <div class="flex flex-col gap-2 text-gray-600 text-sm mb-4">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span>Oyun: <?= escape($tournament['game_name']) ?></span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span>Tarih: <?= format_date($tournament['start_date']) ?></span>
                                    </div>
                                </div>
                                
                                <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="block w-full text-center py-2 bg-indigo-50 text-indigo-600 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                                    Turnuvayı Görüntüle
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Profil Ayarları Sekmesi -->
        <div class="tab-content hidden p-6" id="settings-tab">
            <h3 class="text-xl font-bold text-gray-800 mb-6">Profil Ayarları</h3>
            
            <form action="<?= url('/profile/update') ?>" method="post" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Sol Kolon -->
                    <div class="space-y-6">
                        <h4 class="font-semibold text-lg border-b border-gray-200 pb-2 text-indigo-800">Genel Bilgiler</h4>
                        
                        <div>
                            <label for="username" class="block text-gray-700 font-medium mb-2">Kullanıcı Adı:</label>
                            <input type="text" id="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" value="<?= escape($user['username']) ?>" disabled>
                            <p class="mt-1 text-sm text-gray-500">Kullanıcı adı değiştirilemez</p>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">E-posta:</label>
                            <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($user['email']) ?>" required>
                        </div>
                        
                        <div>
                            <label for="full_name" class="block text-gray-700 font-medium mb-2">Tam Ad:</label>
                            <input type="text" name="full_name" id="full_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($user['full_name'] ?? '') ?>">
                        </div>
                        
                        <div>
                            <label for="bio" class="block text-gray-700 font-medium mb-2">Hakkımda:</label>
                            <textarea name="bio" id="bio" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" rows="3"><?= escape($user['bio'] ?? '') ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Sağ Kolon -->
                    <div class="space-y-6">
                        <h4 class="font-semibold text-lg border-b border-gray-200 pb-2 text-indigo-800">Oyun ve İletişim Bilgileri</h4>
                        
                        <div>
                            <label for="game_id" class="block text-gray-700 font-medium mb-2">Oyuncu ID:</label>
                            <input type="text" name="game_id" id="game_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($user['game_id'] ?? '') ?>">
                            <p class="mt-1 text-sm text-gray-500">Oyun içi kullanıcı adınız veya hesap numaranız</p>
                        </div>
                        
                        <div>
                            <label for="discord" class="block text-gray-700 font-medium mb-2">Discord:</label>
                            <input type="text" name="discord" id="discord" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="<?= escape($user['discord'] ?? '') ?>">
                            <p class="mt-1 text-sm text-gray-500">Discord kullanıcı adınız (örn: username#1234)</p>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Profil Resmi:</label>
                            <div class="flex items-center mb-4">
                                <?php if (!empty($user['avatar'])): ?>
                                    <img src="<?= url('/uploads/avatars/' . $user['avatar']) ?>" alt="<?= escape($user['username']) ?>" class="w-16 h-16 rounded-full object-cover">
                                <?php else: ?>
                                    <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-full font-bold text-xl">
                                        <?= strtoupper(substr($user['username'], 0, 2)) ?>
                                    </div>
                                <?php endif; ?>
                                <div class="ml-4">
                                    <label for="avatar" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 cursor-pointer inline-block transition-colors">
                                        Resim Seç
                                        <input type="file" name="avatar" id="avatar" class="hidden" accept="image/*">
                                    </label>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500">Önerilen: 500x500 piksel, PNG veya JPG formatında</p>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6 mt-6">
                    <h4 class="font-semibold text-lg mb-4 text-indigo-800">Şifre Değiştir</h4>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="current_password" class="block text-gray-700 font-medium mb-2">Mevcut Şifre:</label>
                            <input type="password" name="current_password" id="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        
                        <div>
                            <label for="new_password" class="block text-gray-700 font-medium mb-2">Yeni Şifre:</label>
                            <input type="password" name="new_password" id="new_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <p class="mt-1 text-sm text-gray-500">En az 6 karakter</p>
                        </div>
                        
                        <div>
                            <label for="new_password_confirm" class="block text-gray-700 font-medium mb-2">Yeni Şifre Tekrar:</label>
                            <input type="password" name="new_password_confirm" id="new_password_confirm" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Son güncelleme: <?= format_date($user['updated_at']) ?></p>
                    </div>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Profili Güncelle
                    </button>
                </div>
            </form>
        </div>
    </div>
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
    // Sekme değiştirme işlevselliği
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
    
    // URL hash parametresine göre sekme seçme
    function selectTabFromHash() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            const tabLink = document.querySelector(`.tab-nav-item[data-tab="${hash}"]`);
            if (tabLink) {
                tabLink.click();
            }
        }
    }
    
    // Sayfa yüklendiğinde ve hash değiştiğinde sekme seçme
    selectTabFromHash();
    window.addEventListener('hashchange', selectTabFromHash);
    
    // Profil resmi yükleme önizlemesi
    const avatarInput = document.getElementById('avatar');
    if (avatarInput) {
        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Önizleme görüntüsünü güncelle
                    const previewContainer = document.querySelector('label[for="avatar"]').parentNode.parentNode;
                    const currentPreview = previewContainer.querySelector('img, div.w-16.h-16.bg-indigo-600');
                    
                    if (currentPreview.tagName === 'IMG') {
                        currentPreview.src = e.target.result;
                    } else {
                        // Div yerine img oluştur
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Profil Resmi Önizleme';
                        img.className = 'w-16 h-16 rounded-full object-cover';
                        
                        currentPreview.parentNode.replaceChild(img, currentPreview);
                    }
                };
                reader.readAsDataURL(file);
                
                // Dosya adını göster
                const fileNameElement = document.querySelector('label[for="avatar"]');
                if (fileNameElement) {
                    fileNameElement.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
                }
            }
        });
    }
});
</script>