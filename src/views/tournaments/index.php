<!-- Hero Section -->
<div class="relative py-12 overflow-hidden bg-gradient-to-r from-indigo-800 to-purple-900">
  <!-- Arka plan deseni -->
  <div class="absolute inset-0 opacity-20">
    <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
      <defs>
        <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
          <rect width="1" height="1" fill="white" x="0" y="0" />
        </pattern>
      </defs>
      <rect width="100%" height="100%" fill="url(#grid)" />
    </svg>
  </div>
  
  <div class="container px-4 mx-auto relative">
    <div class="max-w-4xl mx-auto text-center">
      <h1 class="text-4xl font-bold text-white mb-4">Boscaler Turnuvalar</h1>
      <p class="text-xl text-indigo-100 mb-8">Yeteneklerinizi sergileyebileceğiniz profesyonel e-spor turnuvalarına katılın</p>
      
      <!-- Turnuva Filtreleri -->
      <div class="bg-white bg-opacity-10 backdrop-blur-sm p-4 rounded-xl mb-8 shadow-lg">
        <div class="flex flex-wrap gap-3 justify-center">
          <a href="#aktif" class="px-4 py-2 bg-white text-indigo-800 rounded-lg font-medium shadow-sm hover:shadow-md transition">Aktif Turnuvalar</a>
          <a href="#yaklaşan" class="px-4 py-2 bg-indigo-900 bg-opacity-40 text-white rounded-lg font-medium hover:bg-opacity-60 transition">Yaklaşan Turnuvalar</a>
          <a href="#tamamlanan" class="px-4 py-2 bg-indigo-900 bg-opacity-40 text-white rounded-lg font-medium hover:bg-opacity-60 transition">Tamamlanan Turnuvalar</a>
        </div>
      </div>
      
      <div class="flex justify-center items-center text-white text-sm space-x-6">
        <span class="flex items-center">
          <span class="w-3 h-3 bg-green-500 rounded-full inline-block mr-2"></span>
          Aktif
        </span>
        <span class="flex items-center">
          <span class="w-3 h-3 bg-blue-500 rounded-full inline-block mr-2"></span>
          Kayıt Açık
        </span>
        <span class="flex items-center">
          <span class="w-3 h-3 bg-purple-500 rounded-full inline-block mr-2"></span>
          Tamamlandı
        </span>
        <span class="flex items-center">
          <span class="w-3 h-3 bg-gray-500 rounded-full inline-block mr-2"></span>
          Taslak
        </span>
      </div>
    </div>
  </div>
  
  <!-- Alt dalga şekli -->
  <div class="absolute bottom-0 left-0 right-0 overflow-hidden">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 80" class="w-full h-auto">
      <path fill="white" fill-opacity="1" d="M0,64L80,53.3C160,43,320,21,480,21.3C640,21,800,43,960,48C1120,53,1280,43,1360,37.3L1440,32L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
    </svg>
  </div>
</div>

<!-- Oyun Filtreleri -->
<div class="py-6 bg-white">
  <div class="container px-4 mx-auto">
    <div class="flex flex-wrap gap-3 justify-center items-center">
      <button class="inline-flex items-center px-4 py-2 bg-indigo-700 text-white rounded-lg font-medium hover:bg-indigo-800 transition">
        <span class="mr-2">Tüm Oyunlar</span>
      </button>
      
      <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
        <img src="<?= url('/assets/images/games/lol.png') ?>" alt="LoL" class="w-5 h-5 mr-2" 
             onerror="this.onerror=null; this.src='https://via.placeholder.com/20/4F46E5/ffffff?text=LoL';">
        <span>LoL</span>
      </button>
      
      <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
        <img src="<?= url('/assets/images/games/valorant.png') ?>" alt="Valorant" class="w-5 h-5 mr-2"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/20/FF4655/ffffff?text=V';">
        <span>Valorant</span>
      </button>
      
      <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
        <img src="<?= url('/assets/images/games/cs2.png') ?>" alt="CS2" class="w-5 h-5 mr-2"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/20/1F2937/ffffff?text=CS';">
        <span>CS2</span>
      </button>
      
      <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition">
        <img src="<?= url('/assets/images/games/r6.png') ?>" alt="R6" class="w-5 h-5 mr-2"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/20/F59E0B/ffffff?text=R6';">
        <span>R6 Siege</span>
      </button>
    </div>
  </div>
</div>

<!-- Aktif Turnuvalar -->
<section id="aktif" class="py-12 bg-white">
  <div class="container px-4 mx-auto">
    <div class="flex items-center justify-between mb-8">
      <h2 class="text-2xl font-bold text-gray-900">Aktif Turnuvalar</h2>
      <div class="inline-flex items-center text-indigo-600 font-medium hover:text-indigo-700">
        <span class="border-b border-dashed border-indigo-600">Gelişmiş Filtrele</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
          <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
        </svg>
      </div>
    </div>
    
    <?php if (empty($activeTournaments)): ?>
      <div class="bg-gray-50 rounded-xl p-10 text-center border border-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Şu anda aktif turnuva bulunmamaktadır</h3>
        <p class="text-gray-500">Yakında yeni turnuvalar eklenecektir.</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($activeTournaments as $tournament): ?>
          <div class="group relative">
            <!-- Durum işareti (sol üst köşede) -->
            <div class="absolute top-4 left-4 z-20">
              <?php 
              $statusClasses = [
                'draft' => 'bg-gray-500',
                'registration' => 'bg-blue-500',
                'active' => 'bg-green-500',
                'completed' => 'bg-purple-500',
                'cancelled' => 'bg-red-500'
              ];
              $statusClass = isset($statusClasses[$tournament['status']]) ? $statusClasses[$tournament['status']] : 'bg-gray-500';
              ?>
              <span class="w-3 h-3 <?= $statusClass ?> rounded-full block"></span>
            </div>
            
            <!-- Kart -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden h-full flex flex-col hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 relative">
              <div class="h-48 overflow-hidden relative">
                <!-- Banner görseli veya gradient arka plan -->
                <?php if (!empty($tournament['banner'])): ?>
                  <img src="<?= url('/uploads/tournament_banners/' . $tournament['banner']) ?>" alt="<?= escape($tournament['name']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <?php else: ?>
                  <div class="w-full h-full bg-gradient-to-br from-indigo-600 to-purple-700"></div>
                <?php endif; ?>
                
                <!-- Karanlık overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                <!-- Oyun ikonu sağ üstte -->
                <div class="absolute top-3 right-3 bg-black bg-opacity-50 rounded-full p-1 backdrop-blur-sm">
                  <img src="<?= url('/assets/images/games/' . $tournament['slug'] . '.png') ?>" alt="<?= escape($tournament['game_name']) ?>" class="w-8 h-8 rounded-full" 
                       onerror="this.onerror=null; this.src='https://via.placeholder.com/32/4F46E5/ffffff?text=<?= substr($tournament['game_name'], 0, 1) ?>';">
                </div>
                
                <!-- İçerik (altta) -->
                <div class="absolute bottom-0 left-0 right-0 p-4">
                  <h3 class="text-xl font-bold text-white"><?= escape($tournament['name']) ?></h3>
                </div>
              </div>
              
              <div class="p-5 flex-grow flex flex-col">
                <div class="flex items-center text-gray-700 mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <span class="font-medium"><?= format_date($tournament['start_date']) ?></span>
                </div>
                
                <div class="flex items-center text-gray-700 mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                  <span class="font-medium"><?= escape($tournament['team_limit']) ?> Takım</span>
                </div>
                
                <div class="flex items-center text-gray-700 mb-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="font-medium"><?= format_money($tournament['prize_pool']) ?></span>
                </div>
                
                <div class="flex items-center text-gray-700 mb-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                  </svg>
                  <span class="font-medium"><?= formatTournamentFormat($tournament['format']) ?></span>
                </div>
                
                <div class="mt-auto pt-4">
                  <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="block w-full text-center py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                    Detayları Görüntüle
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Yaklaşan Turnuvalar -->
<section id="yaklaşan" class="py-12 bg-gray-50">
  <div class="container px-4 mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Yaklaşan Turnuvalar</h2>
    
    <?php if (empty($upcomingTournaments)): ?>
      <div class="bg-white rounded-xl p-10 text-center border border-gray-100 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Şu anda yaklaşan turnuva bulunmamaktadır</h3>
        <p class="text-gray-500">Çok yakında yeni turnuvalar duyurulacak!</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($upcomingTournaments as $tournament): ?>
          <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col hover:shadow-lg transition-all duration-300">
            <div class="p-6 bg-indigo-50 flex justify-between items-center">
              <div class="flex items-center">
                <img src="<?= url('/assets/images/games/' . $tournament['slug'] . '.png') ?>" alt="<?= escape($tournament['game_name']) ?>" class="w-10 h-10 mr-3 rounded" 
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/40/4F46E5/ffffff?text=<?= substr($tournament['game_name'], 0, 1) ?>';">
                <h3 class="text-lg font-bold text-gray-800"><?= escape($tournament['name']) ?></h3>
              </div>
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                Yakında
              </span>
            </div>
            
            <div class="p-6 flex-grow flex flex-col">
              <div class="flex items-center justify-between text-gray-700 mb-2">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <span class="font-medium">Başlangıç:</span>
                </div>
                <span><?= format_date($tournament['start_date']) ?></span>
              </div>
              
              <div class="flex items-center justify-between text-gray-700 mb-2">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="font-medium">Kayıt Başlangıç:</span>
                </div>
                <span><?= format_date($tournament['registration_start']) ?></span>
              </div>
              
              <div class="flex items-center justify-between text-gray-700 mb-4">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span class="font-medium">Ödül Havuzu:</span>
                </div>
                <span><?= format_money($tournament['prize_pool']) ?></span>
              </div>
              
              <div class="mt-auto pt-4">
                <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="block w-full text-center py-3 border border-indigo-600 text-indigo-600 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                  Detayları Görüntüle
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Tamamlanan Turnuvalar -->
<section id="tamamlanan" class="py-12 bg-white">
  <div class="container px-4 mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-8">Tamamlanan Turnuvalar</h2>
    
    <?php if (empty($completedTournaments)): ?>
      <div class="bg-gray-50 rounded-xl p-10 text-center border border-gray-100">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Henüz tamamlanan turnuva bulunmamaktadır</h3>
        <p class="text-gray-500">Aktif turnuvalarımız tamamlandığında burada listelenecektir.</p>
      </div>
    <?php else: ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($completedTournaments as $tournament): ?>
          <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300">
            <div class="p-6 flex flex-col">
              <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800"><?= escape($tournament['name']) ?></h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                  Tamamlandı
                </span>
              </div>
              
              <div class="flex items-center mb-2">
                <img src="<?= url('/assets/images/games/' . $tournament['slug'] . '.png') ?>" alt="<?= escape($tournament['game_name']) ?>" class="w-6 h-6 mr-2 rounded" 
                     onerror="this.onerror=null; this.src='https://via.placeholder.com/24/4F46E5/ffffff?text=<?= substr($tournament['game_name'], 0, 1) ?>';">
                <span class="text-gray-700"><?= escape($tournament['game_name']) ?></span>
              </div>
              
              <div class="flex items-center text-gray-700 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span><?= format_date($tournament['start_date']) ?> - <?= format_date($tournament['end_date']) ?></span>
              </div>
              
              <div class="flex items-center text-gray-700 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span><?= format_money($tournament['prize_pool']) ?></span>
              </div>
              
              <div class="mt-4">
                <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="block w-full text-center py-3 bg-gray-200 text-gray-800 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
                  Sonuçları Görüntüle
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- CTA Bölümü -->
<div class="relative py-12 bg-gradient-to-r from-indigo-600 to-indigo-800 overflow-hidden">
  <!-- Arka plan deseni -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;"></div>
  </div>
  
  <div class="container px-4 mx-auto relative">
    <div class="max-w-3xl mx-auto text-center">
      <h2 class="text-3xl font-bold text-white mb-6">Kendi Turnuvanı Öner</h2>
      <p class="text-xl text-indigo-100 mb-8">Takımınız için özel bir turnuva düzenlemek mi istiyorsunuz? Boscaler Esports ekibi olarak size özel turnuvalar düzenliyoruz.</p>
      
      <a href="#" class="inline-block px-8 py-4 bg-white text-indigo-700 font-bold rounded-lg shadow-lg hover:shadow-white/20 transition duration-300">
        İletişime Geç
      </a>
    </div>
  </div>
</div>

<?php  
// Format türünü formatla - bu fonksiyon sayfanın en başında tanımlanmalıdır
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