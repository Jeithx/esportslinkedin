<div class="bg-white rounded-xl shadow-lg p-8 mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Takımlar</h1>
            <p class="text-gray-600">Boscaler Esports'un profesyonel takımlarına göz atın veya kendi takımınızı oluşturun.</p>
        </div>
        
        <?php if (Auth::isLoggedIn()): ?>
            <a href="<?= url('/teams/create') ?>" class="mt-4 md:mt-0 inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Yeni Takım Oluştur
            </a>
        <?php else: ?>
            <a href="<?= url('/login') ?>" class="mt-4 md:mt-0 inline-flex items-center px-5 py-3 bg-indigo-100 text-indigo-600 font-medium rounded-lg hover:bg-indigo-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Giriş Yap ve Takım Kur
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if (empty($teams)): ?>
    <div class="bg-white rounded-xl shadow-md p-12 text-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <h3 class="text-xl font-medium text-gray-800 mb-2">Henüz kayıtlı takım bulunmamaktadır</h3>
        <p class="text-gray-600 mb-6">İlk takımı oluşturmak için harekete geçin ve e-spor sahnesinde yerinizi alın!</p>
        
        <?php if (Auth::isLoggedIn()): ?>
            <a href="<?= url('/teams/create') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                İlk Takımı Oluştur
            </a>
        <?php else: ?>
            <a href="<?= url('/login') ?>" class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Giriş Yap
            </a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($teams as $team): ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
                <div class="p-6 flex items-center justify-center bg-gray-50 h-48">
                    <?php if (!empty($team['logo'])): ?>
                        <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" class="h-32 w-32 object-contain">
                    <?php else: ?>
                        <div class="h-24 w-24 rounded-full bg-indigo-600 text-white flex items-center justify-center text-3xl font-bold"><?= substr($team['name'], 0, 2) ?></div>
                    <?php endif; ?>
                </div>
                <div class="p-5">
                    <h3 class="text-xl font-bold text-gray-800 mb-2"><?= escape($team['name']) ?></h3>
                    <p class="text-gray-600 mb-4 line-clamp-2"><?= escape($team['description']) ?></p>
                    <div class="flex items-center text-gray-500 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span><?= $team['member_count'] ?> Üye</span>
                    </div>
                    <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-block w-full text-center py-2 border border-indigo-600 text-indigo-600 rounded-lg hover:bg-indigo-600 hover:text-white transition duration-300">Takımı Görüntüle</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>