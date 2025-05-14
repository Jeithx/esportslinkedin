<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-8">
        <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <?= escape($team['name']) ?> Takımına Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Bekleyen Davetler</h1>
            
            <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-flex items-center px-4 py-2 bg-white text-indigo-600 rounded-lg hover:bg-indigo-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Yeni Davet Gönder
            </a>
        </div>
        
        <div class="p-6">
            <?php if (empty($invitations)): ?>
                <div class="bg-indigo-50 rounded-xl p-10 text-center border border-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-indigo-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Bekleyen davet bulunmamaktadır</h3>
                    <p class="text-gray-600 mb-6">Şu anda bekleyen davet bulunmuyor. Yeni üyeler davet edebilirsiniz.</p>
                    <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Üye Davet Et
                    </a>
                </div>
            <?php else: ?>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-3 px-4 text-left bg-gray-50 text-gray-700 font-semibold">E-posta</th>
                            <th class="py-3 px-4 text-left bg-gray-50 text-gray-700 font-semibold">Gönderilme Tarihi</th>
                            <th class="py-3 px-4 text-left bg-gray-50 text-gray-700 font-semibold">Son Geçerlilik</th>
                            <th class="py-3 px-4 text-left bg-gray-50 text-gray-700 font-semibold">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach ($invitations as $invitation): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4"><?= escape($invitation['recipient_email']) ?></td>
                                <td class="py-3 px-4"><?= format_date($invitation['created_at']) ?></td>
                                <td class="py-3 px-4"><?= format_date($invitation['expires_at']) ?></td>
                                <td class="py-3 px-4">
                                    <form action="<?= url('/teams/cancel-invitation') ?>" method="post" onsubmit="return confirm('Bu daveti iptal etmek istediğinize emin misiniz?');">
                                        <input type="hidden" name="invitation_id" value="<?= $invitation['id'] ?>">
                                        <input type="hidden" name="team_id" value="<?= $team['id'] ?>">
                                        <button type="submit" class="text-red-600 hover:text-red-800">İptal Et</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>