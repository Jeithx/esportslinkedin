<!-- src/views/teams/invitations.php -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="<?= url('/profile') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Profilime Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Takım Davetlerim</h1>
        </div>
        
        <div class="p-6">
            <?php if (empty($invitations)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Bekleyen davet bulunmamaktadır</h3>
                    <p class="text-gray-600 mb-6">Şu anda takımlardan herhangi bir davet almadınız.</p>
                    <a href="<?= url('/teams') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        Takımları Keşfet
                    </a>
                </div>
            <?php else: ?>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Bekleyen Davetler</h2>
                
                <div class="space-y-4">
                    <?php foreach ($invitations as $invitation): ?>
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-4">
                            <div class="flex items-center mb-4">
                                <?php if (!empty($invitation['team_logo'])): ?>
                                    <img src="<?= url('/uploads/team_logos/' . $invitation['team_logo']) ?>" alt="<?= escape($invitation['team_name']) ?>" class="w-12 h-12 rounded-full object-cover mr-4">
                                <?php else: ?>
                                    <div class="w-12 h-12 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold">
                                        <?= strtoupper(substr($invitation['team_name'], 0, 2)) ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div>
                                    <h3 class="text-lg font-semibold"><?= escape($invitation['team_name']) ?></h3>
                                    <p class="text-sm text-gray-600">
                                        <span class="font-medium"><?= escape($invitation['sender_name']) ?></span> tarafından davet edildiniz
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        <?= time_ago($invitation['created_at']) ?> - 
                                        <?= format_date($invitation['expires_at'], 'd.m.Y H:i') ?> tarihine kadar geçerli
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-3">
                                <form action="<?= url('/teams/reject-invitation') ?>" method="post">
                                    <input type="hidden" name="invitation_id" value="<?= $invitation['id'] ?>">
                                    <button type="submit" class="px-4 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                                        Reddet
                                    </button>
                                </form>
                                
                                <a href="<?= url('/teams/join?token=' . $invitation['token']) ?>" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                    Kabul Et
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>