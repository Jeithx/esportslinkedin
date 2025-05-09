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

// Format türünü formatla
function formatTournamentFormat($format) {
    $formats = [
        'single_elimination' => 'Tek Eleme',
        'double_elimination' => 'Çift Eleme',
        'round_robin' => 'Lig Usulü',
        'swiss' => 'İsviçre Sistemi'
    ];
    
    return isset($formats[$format]) ? $formats[$format] : $format;
}
?>

<div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
    <?php if (!empty($tournament['banner'])): ?>
        <div class="w-full h-48 md:h-64 overflow-hidden">
            <img src="<?= url('/uploads/tournament_banners/' . $tournament['banner']) ?>" alt="<?= escape($tournament['name']) ?>" class="w-full h-full object-cover">
        </div>
    <?php endif; ?>
    
    <div class="p-6">
        <div class="flex flex-wrap items-center justify-between mb-4">
            <h1 class="text-3xl font-bold text-gray-800 mr-3"><?= escape($tournament['name']) ?></h1>
            <div class="inline-flex items-center px-3 py-1 mt-2 sm:mt-0 rounded-full text-sm font-medium 
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
            </div>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
            <div class="bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium"><?= escape($tournament['game_name']) ?></span>
                </div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="font-medium"><?= format_date($tournament['start_date']) ?></span>
                </div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium"><?= format_money($tournament['prize_pool']) ?></span>
                </div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="font-medium"><?= escape($tournament['team_limit']) ?> Takım</span>
                </div>
            </div>
            <div class="bg-gray-50 p-3 rounded-lg">
                <div class="flex items-center text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span class="font-medium"><?= formatTournamentFormat($tournament['format']) ?></span>
                </div>
            </div>
        </div>
        
        <?php if (!empty($tournament['description'])): ?>
            <div class="text-gray-700 mb-6">
                <?= nl2br(escape($tournament['description'])) ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <div class="flex border-b border-gray-200 overflow-x-auto">
        <button class="tab-nav-item active whitespace-nowrap px-6 py-3 font-medium text-gray-700 border-b-2 border-indigo-600 focus:outline-none" data-tab="brackets">Turnuva Ağacı</button>
        <button class="tab-nav-item whitespace-nowrap px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="teams">Takımlar</button>
        <button class="tab-nav-item whitespace-nowrap px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="rules">Kurallar</button>
        <button class="tab-nav-item whitespace-nowrap px-6 py-3 font-medium text-gray-500 hover:text-gray-700 focus:outline-none" data-tab="registration">Kayıt</button>
    </div>
    
    <div class="tab-content active p-6" id="brackets-tab">
        <?php if ($tournament['status'] == 'draft' || $tournament['status'] == 'registration'): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">
                Turnuva henüz başlamadı. Eşleşmeler belirlendiğinde turnuva ağacı burada görüntülenecektir.
            </div>
        <?php elseif (empty($matches)): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">
                Henüz maç bilgisi bulunmamaktadır.
            </div>
        <?php else: ?>
            <div class="tournament-bracket overflow-x-auto">
                <div class="bracket-container flex gap-8 min-w-max pb-4">
                    <?php
                    // Tüm turları grupla
                    $roundMatches = [];
                    $maxRound = 0;
                    
                    foreach ($matches as $match) {
                        $round = $match['round'];
                        if (!isset($roundMatches[$round])) {
                            $roundMatches[$round] = [];
                        }
                        $roundMatches[$round][] = $match;
                        
                        if ($round > $maxRound) {
                            $maxRound = $round;
                        }
                    }
                    
                    // Her tur için
                    for ($round = 1; $round <= $maxRound; $round++): 
                        $roundName = $round == $maxRound ? 'Final' : 
                                    ($round == $maxRound - 1 ? 'Yarı Final' : 
                                    ($round == $maxRound - 2 ? 'Çeyrek Final' : 
                                    $round . '. Tur'));
                    ?>
                        <div class="bracket-round flex-1 flex flex-col min-w-[200px]">
                            <div class="text-center font-semibold text-gray-800 mb-4"><?= $roundName ?></div>
                            
                            <?php if (isset($roundMatches[$round])): ?>
                                <?php foreach ($roundMatches[$round] as $match): ?>
                                    <div class="bg-white rounded-lg shadow border border-gray-200 mb-4 overflow-hidden">
                                        <div class="bg-gray-50 py-2 px-3 text-xs text-gray-600 border-b border-gray-200">
                                            Maç #<?= $match['match_number'] ?>
                                            <?php if ($match['scheduled_at']): ?>
                                                - <?= format_date($match['scheduled_at']) ?>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="flex items-center justify-between p-3 border-b border-gray-100
                                            <?= $match['winner_id'] == $match['team1_id'] ? 'bg-green-50' : ($match['loser_id'] == $match['team1_id'] ? 'bg-gray-50' : '') ?>">
                                            <div class="flex items-center">
                                                <?php if ($match['team1_id']): ?>
                                                    <?php if ($match['team1_logo']): ?>
                                                        <img src="<?= url('/uploads/team_logos/' . $match['team1_logo']) ?>" alt="<?= escape($match['team1_name']) ?>" class="w-6 h-6 mr-2 rounded-full">
                                                    <?php endif; ?>
                                                    <span class="font-medium text-gray-800"><?= escape($match['team1_name']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-gray-500 italic">TBD</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="font-bold text-lg <?= $match['winner_id'] == $match['team1_id'] ? 'text-green-600' : 'text-gray-700' ?>">
                                                <?= isset($match['score_team1']) ? $match['score_team1'] : '-' ?>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between p-3
                                            <?= $match['winner_id'] == $match['team2_id'] ? 'bg-green-50' : ($match['loser_id'] == $match['team2_id'] ? 'bg-gray-50' : '') ?>">
                                            <div class="flex items-center">
                                                <?php if ($match['team2_id']): ?>
                                                    <?php if ($match['team2_logo']): ?>
                                                        <img src="<?= url('/uploads/team_logos/' . $match['team2_logo']) ?>" alt="<?= escape($match['team2_name']) ?>" class="w-6 h-6 mr-2 rounded-full">
                                                    <?php endif; ?>
                                                    <span class="font-medium text-gray-800"><?= escape($match['team2_name']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-gray-500 italic">TBD</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="font-bold text-lg <?= $match['winner_id'] == $match['team2_id'] ? 'text-green-600' : 'text-gray-700' ?>">
                                                <?= isset($match['score_team2']) ? $match['score_team2'] : '-' ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="bg-white rounded-lg shadow border border-gray-200 mb-4 overflow-hidden">
                                    <div class="bg-gray-50 py-2 px-3 text-xs text-gray-600 border-b border-gray-200">Henüz Belirlenmedi</div>
                                    <div class="flex items-center justify-between p-3 border-b border-gray-100">
                                        <span class="text-gray-500 italic">TBD</span>
                                        <span class="font-bold text-lg text-gray-700">-</span>
                                    </div>
                                    <div class="flex items-center justify-between p-3">
                                        <span class="text-gray-500 italic">TBD</span>
                                        <span class="font-bold text-lg text-gray-700">-</span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content hidden p-6" id="teams-tab">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Takımlar</h3>
        
        <?php if (empty($teams)): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">
                Henüz kayıtlı takım bulunmamaktadır.
            </div>
        <?php else: ?>
            <div class="space-y-3">
                <?php foreach ($teams as $team): ?>
                    <div class="bg-white rounded-lg shadow border border-gray-200 p-4 flex flex-col sm:flex-row sm:items-center justify-between">
                        <div class="flex items-center mb-3 sm:mb-0">
                            <?php if (!empty($team['logo'])): ?>
                                <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?>" class="w-10 h-10 mr-3 rounded-full object-cover">
                            <?php else: ?>
                                <div class="w-10 h-10 bg-indigo-600 text-white flex items-center justify-center rounded-full mr-3 font-bold">
                                    <?= substr($team['name'], 0, 2) ?>
                                </div>
                            <?php endif; ?>
                            
                            <div>
                                <h4 class="font-bold text-gray-800"><?= escape($team['name']) ?></h4>
                                <?php if (isset($team['seed'])): ?>
                                    <span class="text-sm text-gray-600">Sıralama: <?= $team['seed'] ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            <?php 
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'approved' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800'
                            ];
                            $statusClass = isset($statusClasses[$team['registration_status']]) ? $statusClasses[$team['registration_status']] : 'bg-gray-100 text-gray-800';
                            echo $statusClass;
                            ?>">
                                <?php 
                                $statusTexts = [
                                    'pending' => 'Onay Bekliyor',
                                    'approved' => 'Onaylandı',
                                    'rejected' => 'Reddedildi'
                                ];
                                echo isset($statusTexts[$team['registration_status']]) ? $statusTexts[$team['registration_status']] : $team['registration_status'];
                                ?>
                            </span>
                            
                            <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 text-indigo-600 rounded hover:bg-indigo-600 hover:text-white transition text-sm">
                                Detaylar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content hidden p-6" id="rules-tab">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Kurallar</h3>
        
        <?php if (empty($tournament['rules'])): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">
                Henüz detaylı kural bilgisi eklenmemiştir.
            </div>
        <?php else: ?>
            <div class="prose max-w-none text-gray-700">
                <?= nl2br(escape($tournament['rules'])) ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="tab-content hidden p-6" id="registration-tab">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Turnuvaya Kayıt</h3>
        
        <?php if ($tournament['status'] == 'registration'): ?>
            <?php if (Auth::isLoggedIn()): ?>
                <?php if ($isTeamRegistered): ?>
                    <div class="bg-green-50 text-green-800 p-4 rounded-lg border border-green-200">
                        Takımınız bu turnuvaya zaten kayıtlıdır.
                    </div>
                <?php else: ?>
                    <?php if (!empty($userTeams)): ?>
                        <div class="bg-white rounded-lg shadow border border-gray-200 p-6">
                            <h4 class="font-bold text-lg mb-4">Turnuvaya Kaydol</h4>
                            <form action="<?= url('/tournaments/register') ?>" method="post">
                                <input type="hidden" name="tournament_id" value="<?= $tournament['id'] ?>">
                                
                                <div class="mb-4">
                                    <label for="team_id" class="block text-gray-700 font-medium mb-2">Takımınızı Seçin:</label>
                                    <select name="team_id" id="team_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                        <option value="">-- Takım Seçin --</option>
                                        <?php foreach ($userTeams as $team): ?>
                                            <option value="<?= $team['id'] ?>"><?= escape($team['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div>
                                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Kaydol</button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="bg-yellow-50 text-yellow-800 p-4 rounded-lg border border-yellow-200">
                            Turnuvaya kaydolmak için bir takıma sahip olmalısınız. 
                            <a href="<?= url('/teams') ?>" class="text-indigo-600 hover:underline font-medium">Takım oluşturmak için tıklayın.</a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">
                    Turnuvaya kaydolmak için önce <a href="<?= url('/login') ?>" class="text-indigo-600 hover:underline font-medium">giriş yapmalısınız</a>.
                </div>
            <?php endif; ?>
        <?php elseif ($tournament['status'] == 'draft'): ?>
            <div class="bg-blue-50 text-blue-800 p-4 rounded-lg border border-blue-200">
                Turnuva kayıtları henüz açılmamıştır. Kayıt tarihi: <?= format_date($tournament['registration_start']) ?>
            </div>
        <?php else: ?>
            <div class="bg-yellow-50 text-yellow-800 p-4 rounded-lg border border-yellow-200">
                Bu turnuva için kayıtlar kapanmıştır.
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab değiştirme
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
});
</script>