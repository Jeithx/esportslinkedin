<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="<?= url('/teams/invitations') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Davetlerime Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Takım Daveti</h1>
        </div>
        
        <div class="p-6">
            <div class="bg-indigo-50 rounded-xl p-6 mb-6 border border-indigo-100">
                <div class="flex items-center mb-4">
                    <?php if (!empty($invitation['team_logo'])): ?>
                        <img src="<?= url('/uploads/team_logos/' . $invitation['team_logo']) ?>" alt="<?= escape($invitation['team_name']) ?>" class="w-16 h-16 rounded-full object-cover mr-4">
                    <?php else: ?>
                        <div class="w-16 h-16 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-4 font-bold text-2xl">
                            <?= strtoupper(substr($invitation['team_name'], 0, 2)) ?>
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <h2 class="text-xl font-bold text-gray-800"><?= escape($invitation['team_name']) ?></h2>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium"><?= escape($invitation['sender_name']) ?></span> tarafından davet edildiniz
                        </p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <?php if (!empty($invitation['team_description'])): ?>
                        <h3 class="font-semibold text-gray-800 mb-2">Takım Hakkında:</h3>
                        <p class="text-gray-600"><?= nl2br(escape($invitation['team_description'])) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="text-sm text-gray-500 mb-4">
                    Bu davet <?= format_date($invitation['expires_at'], 'd.m.Y H:i') ?> tarihine kadar geçerlidir.
                </div>
            </div>
            
            <div class="flex justify-center gap-4">
                <form action="<?= url('/teams/reject-invitation') ?>" method="post">
                    <input type="hidden" name="invitation_id" value="<?= $invitation['id'] ?>">
                    <button type="submit" class="px-6 py-3 border border-red-500 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors">
                        Daveti Reddet
                    </button>
                </form>
                
                <a href="<?= url('/teams/accept-invitation?token=' . $token) ?>" class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                    Takıma Katıl
                </a>
            </div>
        </div>
    </div>
</div>