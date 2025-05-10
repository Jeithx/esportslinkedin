<!-- Hero Section - Düzeltilmiş Versiyon -->
<div class="relative overflow-hidden bg-indigo-900 py-16">
  <!-- Yarı saydam arka plan deseni -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;"></div>
  </div>

  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row items-center">
      <!-- Sol taraf: İçerik -->
      <div class="w-full lg:w-1/2 text-center lg:text-left mb-8 lg:mb-0">
        <h1 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-4">
          <span class="block">Profesyonel E-Spor</span>
          <span class="block">Turnuvalarında</span>
          <span class="block mt-2"><span class="text-pink-400">Zirveye</span> Çık</span>
        </h1>
        <p class="text-lg text-indigo-100 mb-8 max-w-xl mx-auto lg:mx-0">
          Boscaler Esports ile yeteneklerini göster, en iyilerle rekabet et ve e-spor dünyasında adını duyur.
        </p>
        <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
          <a href="<?= url('/tournaments') ?>" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition duration-300">
            Turnuvalara Katıl
          </a>
          <a href="<?= url('/teams') ?>" class="px-6 py-3 bg-white bg-opacity-10 text-white font-bold rounded-lg hover:bg-opacity-20 transition duration-300 backdrop-blur-sm">
            Takımını Oluştur
          </a>
        </div>
      </div>
      
      <!-- Sağ taraf: Görsel -->
      <div class="w-full lg:w-1/2">
        <img src="<?= url('/assets/images/hero-image.png') ?>" alt="E-spor Turnuvası" class="w-full max-w-md mx-auto" 
             onerror="this.onerror=null; this.src='https://via.placeholder.com/500x400/4338CA/ffffff?text=BOSCALER+ESPORTS';">
      </div>
    </div>
    
    <!-- İstatistikler - Düzeltilmiş, sabit grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mt-12 mb-4">
      <div class="bg-indigo-800 bg-opacity-50 backdrop-blur-sm rounded-lg p-5 text-center">
        <div class="text-3xl md:text-4xl font-bold text-white mb-1">20+</div>
        <div class="text-indigo-200 text-sm">Turnuva</div>
      </div>
      <div class="bg-indigo-800 bg-opacity-50 backdrop-blur-sm rounded-lg p-5 text-center">
        <div class="text-3xl md:text-4xl font-bold text-white mb-1">200+</div>
        <div class="text-indigo-200 text-sm">Takım</div>
      </div>
      <div class="bg-indigo-800 bg-opacity-50 backdrop-blur-sm rounded-lg p-5 text-center">
        <div class="text-3xl md:text-4xl font-bold text-white mb-1">₺250K+</div>
        <div class="text-indigo-200 text-sm">Ödül Havuzu</div>
      </div>
      <div class="bg-indigo-800 bg-opacity-50 backdrop-blur-sm rounded-lg p-5 text-center">
        <div class="text-3xl md:text-4xl font-bold text-white mb-1">5K+</div>
        <div class="text-indigo-200 text-sm">Oyuncu</div>
      </div>
    </div>
  </div>
  
  <!-- Dalga efekti -->
  <div class="absolute bottom-0 left-0 right-0">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full h-auto fill-current text-gray-100">
      <path d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
    </svg>
  </div>
</div>

<!-- Yaklaşan Turnuvalar - Başlık düzeltmesi -->
<div class="py-16 bg-gray-100">
  <div class="container mx-auto px-4">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900 mb-4">Yaklaşan Turnuvalar</h2>
      <p class="text-gray-600 max-w-3xl mx-auto">Profesyonel espor kariyerinizi ilerletmek ve ödüller kazanmak için son turnuvalarımıza göz atın.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php if (empty($latestTournaments)): ?>
        <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <p class="text-gray-500 text-lg">Şu anda aktif turnuva bulunmamaktadır.</p>
          <p class="text-gray-400 mt-2">Yakında yeni turnuvalar eklenecek!</p>
        </div>
      <?php else: ?>
        <?php foreach ($latestTournaments as $tournament): ?>
        <div class="group relative bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
          <div class="h-48 bg-gradient-to-r 
            <?php 
            $gradients = [
              1 => 'from-blue-500 to-blue-700',  // League of Legends
              2 => 'from-red-500 to-red-700',     // Valorant
              3 => 'from-gray-700 to-gray-900',   // CS2
              4 => 'from-yellow-400 to-yellow-600' // R6
            ];
            echo isset($gradients[$tournament['game_id']]) ? $gradients[$tournament['game_id']] : 'from-indigo-500 to-purple-600';
            ?> 
            relative overflow-hidden">
            <?php if (!empty($tournament['banner'])): ?>
              <img src="<?= url('/uploads/tournament_banners/' . $tournament['banner']) ?>" alt="<?= escape($tournament['name']) ?>" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
            <?php else: ?>
              <!-- Oyun logosunu göstermeye çalış, eğer yoksa varsayılan görsel göster -->
              <div class="absolute inset-0 flex items-center justify-center">
                <?php if (isset($tournament['game_slug'])): ?>
                  <img src="<?= url('/assets/images/games/' . strtolower($tournament['game_slug']) . '.png') ?>" 
                      alt="<?= escape($tournament['game_name']) ?>" 
                      class="w-24 h-24 opacity-30"
                      onerror="this.style.display='none'">
                <?php endif; ?>
              </div>
            <?php endif; ?>
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-4">
              <div class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded text-white bg-pink-500">
                <?= escape($tournament['game_name']) ?>
              </div>
              <h3 class="text-xl font-bold text-white mt-2"><?= escape($tournament['name']) ?></h3>
            </div>
          </div>
          <div class="p-6">
            <div class="flex items-center text-gray-700 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              <span class="font-medium"><?= format_date($tournament['start_date']) ?></span>
            </div>
            <div class="flex items-center text-gray-700 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span class="font-medium"><?= format_money($tournament['prize_pool']) ?></span>
            </div>
            <a href="<?= url('/tournaments/view?id=' . $tournament['id']) ?>" class="block w-full text-center py-3 bg-indigo-50 text-indigo-600 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors duration-300">
              Detayları Görüntüle
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
    <div class="text-center mt-12">
      <a href="<?= url('/tournaments') ?>" class="inline-flex items-center px-6 py-3 border-2 border-indigo-600 text-indigo-600 font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
        Tüm Turnuvaları Görüntüle
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </a>
    </div>
  </div>
</div>

<!-- Öne Çıkan Oyunlar -->
<div class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Desteklenen Oyunlar</h2>
      <p class="text-gray-600 max-w-3xl mx-auto">Türkiye'nin en rekabetçi e-spor turnuvalarına ev sahipliği yapıyoruz.</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
      <div class="bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg p-6 text-center text-white hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <img src="<?= url('/assets/images/games/lol.png') ?>" alt="League of Legends" class="w-20 h-20 mx-auto mb-4" 
             onerror="this.onerror=null; this.src='https://via.placeholder.com/80/4F46E5/ffffff?text=LoL';">
        <h3 class="font-bold text-xl">League of Legends</h3>
      </div>
      <div class="bg-gradient-to-br from-red-500 to-red-700 rounded-xl shadow-lg p-6 text-center text-white hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <img src="<?= url('/assets/images/games/valorant.png') ?>" alt="Valorant" class="w-20 h-20 mx-auto mb-4"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/80/EF4444/ffffff?text=VALORANT';">
        <h3 class="font-bold text-xl">Valorant</h3>
      </div>
      <div class="bg-gradient-to-br from-gray-700 to-gray-900 rounded-xl shadow-lg p-6 text-center text-white hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <img src="<?= url('/assets/images/games/cs2.png') ?>" alt="Counter-Strike 2" class="w-20 h-20 mx-auto mb-4"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/80/1F2937/ffffff?text=CS2';">
        <h3 class="font-bold text-xl">Counter-Strike 2</h3>
      </div>
      <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl shadow-lg p-6 text-center text-black hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <img src="<?= url('/assets/images/games/r6.png') ?>" alt="Rainbow Six Siege" class="w-20 h-20 mx-auto mb-4"
            onerror="this.onerror=null; this.src='https://via.placeholder.com/80/F59E0B/000000?text=R6';">
        <h3 class="font-bold text-xl">Rainbow Six Siege</h3>
      </div>
    </div>
  </div>
</div>

<!-- CTA Section -->
<div class="py-16 bg-gradient-to-r from-indigo-600 to-indigo-800 relative overflow-hidden">
  <!-- Arka plan deseni -->
  <div class="absolute inset-0 opacity-10">
    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.2\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 30px 30px;"></div>
  </div>
  
  <div class="container mx-auto px-6 relative">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Kendi Takımını Kur, Turnuvalara Katıl</h2>
      <p class="text-xl text-indigo-100 mb-8">Profesyonel e-spor sahnesinde yeteneklerinizi göstermenin ve ödüller kazanmanın zamanı geldi!</p>
      
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <?php if (!Auth::isLoggedIn()): ?>
          <a href="<?= url('/register') ?>" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-lg shadow-lg hover:shadow-white/20 transition duration-300">
            Hemen Kaydol
          </a>
          <a href="<?= url('/teams') ?>" class="px-8 py-4 bg-indigo-800 bg-opacity-40 text-white font-bold rounded-lg hover:bg-opacity-60 transition duration-300 backdrop-blur-sm">
            Takımları Keşfet
          </a>
        <?php else: ?>
          <a href="<?= url('/teams/create') ?>" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-lg shadow-lg hover:shadow-white/20 transition duration-300">
            Takım Oluştur
          </a>
          <a href="<?= url('/tournaments') ?>" class="px-8 py-4 bg-indigo-800 bg-opacity-40 text-white font-bold rounded-lg hover:bg-opacity-60 transition duration-300 backdrop-blur-sm">
            Turnuvalara Katıl
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Öne Çıkan Takımlar -->
<div class="py-16 bg-gray-100">
  <div class="container mx-auto px-6">
    <div class="text-center mb-12">
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Öne Çıkan Takımlar</h2>
      <p class="text-gray-600 max-w-3xl mx-auto">En yetenekli oyuncuların oluşturduğu takımlar Boscaler Esports'ta yarışıyor.</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php if (empty($latestTeams)): ?>
        <div class="col-span-full text-center py-12 bg-white rounded-xl shadow-md">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          <p class="text-gray-500 text-lg">Henüz kayıtlı takım bulunmamaktadır.</p>
          <p class="text-gray-400 mt-2">İlk takımı oluşturmak için hemen kaydol!</p>
        </div>
      <?php else: ?>
        <?php foreach ($latestTeams as $team): ?>
          <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
            <div class="w-24 h-24 mb-4 rounded-full bg-indigo-50 p-1">
              <?php if (!empty($team['logo'])): ?>
                <img src="<?= url('/uploads/team_logos/' . $team['logo']) ?>" alt="<?= escape($team['name']) ?> Logo" class="w-full h-full object-contain rounded-full">
              <?php else: ?>
                <div class="w-full h-full rounded-full bg-indigo-600 flex items-center justify-center text-white text-3xl font-bold">
                  <?= substr($team['name'], 0, 2) ?>
                </div>
              <?php endif; ?>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2"><?= escape($team['name']) ?></h3>
            <?php if (!empty($team['description'])): ?>
              <p class="text-gray-600 text-center mb-6 line-clamp-2"><?= escape($team['description']) ?></p>
            <?php endif; ?>
            <a href="<?= url('/teams/view?id=' . $team['id']) ?>" class="mt-auto w-full text-center py-2 bg-indigo-50 text-indigo-600 font-medium rounded-lg hover:bg-indigo-600 hover:text-white transition-colors duration-300">
              Takımı Görüntüle
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    
    <div class="text-center mt-12">
      <a href="<?= url('/teams') ?>" class="inline-flex items-center px-6 py-3 border-2 border-indigo-600 text-indigo-600 font-bold rounded-lg hover:bg-indigo-600 hover:text-white transition-colors">
        Tüm Takımları Görüntüle
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
        </svg>
      </a>
    </div>
  </div>
</div>

<!-- Hakkımızda Section -->
<div class="py-16 bg-white">
  <div class="container mx-auto px-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">Boscaler Esports Hakkında</h2>
        <p class="text-gray-600 mb-6">Boscaler Esports, League of Legends, Valorant, CS2 ve Rainbow Six Siege gibi popüler oyunlarda profesyonel turnuvalar düzenleyen bir organizasyondur. Amacımız, espor tutkunları için adil, rekabetçi ve eğlenceli bir ortam sağlamaktır.</p>
        <p class="text-gray-600 mb-6">Turnuvalarımız, her seviyeden oyuncuya açıktır ve özel ödüller sunmaktadır. Takımınızı oluşturun, yeteneklerinizi gösterin ve espor sahnesinde yerinizi alın!</p>
        <div class="flex flex-wrap gap-4">
          <div class="flex items-center">
            <div class="rounded-full bg-indigo-100 p-3 mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <span class="font-medium text-gray-700">Adil Rekabet</span>
          </div>
          <div class="flex items-center">
            <div class="rounded-full bg-indigo-100 p-3 mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <span class="font-medium text-gray-700">Profesyonel Oyuncular</span>
          </div>
          <div class="flex items-center">
            <div class="rounded-full bg-indigo-100 p-3 mr-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <span class="font-medium text-gray-700">Büyük Ödüller</span>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-4">
            <div class="rounded-lg overflow-hidden shadow-lg transform translate-y-6">
              <img src="<?= url('/assets/images/about-1.jpg') ?>" alt="E-spor Turnuvası" class="w-full h-48 object-cover" 
                   onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300/4338CA/ffffff?text=ESPORTS';">
            </div>
            <div class="rounded-lg overflow-hidden shadow-lg">
              <img src="<?= url('/assets/images/about-2.jpg') ?>" alt="E-spor Turnuvası" class="w-full h-48 object-cover"
                   onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300/6366F1/ffffff?text=GAMING';">
            </div>
          </div>
          <div class="space-y-4">
            <div class="rounded-lg overflow-hidden shadow-lg">
              <img src="<?= url('/assets/images/about-3.jpg') ?>" alt="E-spor Turnuvası" class="w-full h-48 object-cover"
                   onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300/8B5CF6/ffffff?text=TEAMS';">
            </div>
            <div class="rounded-lg overflow-hidden shadow-lg transform translate-y-6">
              <img src="<?= url('/assets/images/about-4.jpg') ?>" alt="E-spor Turnuvası" class="w-full h-48 object-cover"
                   onerror="this.onerror=null; this.src='https://via.placeholder.com/400x300/A855F7/ffffff?text=TOURNAMENTS';">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Sponsorlar
<div class="py-12 bg-gray-100">
  <div class="container mx-auto px-6">
    <div class="text-center mb-8">
      <h2 class="text-2xl font-bold text-gray-700">Sponsorlarımız</h2>
    </div>
    <div class="flex flex-wrap justify-center items-center gap-10 opacity-70">
      <img src="<?= url('/assets/images/sponsors/sponsor1.png') ?>" alt="Sponsor" class="h-12"
           onerror="this.onerror=null; this.src='https://via.placeholder.com/160x60/6B7280/ffffff?text=SPONSOR+1';">
      <img src="<?= url('/assets/images/sponsors/sponsor2.png') ?>" alt="Sponsor" class="h-12"
           onerror="this.onerror=null; this.src='https://via.placeholder.com/160x60/6B7280/ffffff?text=SPONSOR+2';">
      <img src="<?= url('/assets/images/sponsors/sponsor3.png') ?>" alt="Sponsor" class="h-12"
           onerror="this.onerror=null; this.src='https://via.placeholder.com/160x60/6B7280/ffffff?text=SPONSOR+3';">
      <img src="<?= url('/assets/images/sponsors/sponsor4.png') ?>" alt="Sponsor" class="h-12"
           onerror="this.onerror=null; this.src='https://via.placeholder.com/160x60/6B7280/ffffff?text=SPONSOR+4';">
    </div>
  </div>
</div> -->

<style>
@keyframes blob {
  0% {
    transform: translate(0px, 0px) scale(1);
  }
  33% {
    transform: translate(30px, -50px) scale(1.1);
  }
  66% {
    transform: translate(-20px, 20px) scale(0.9);
  }
  100% {
    transform: translate(0px, 0px) scale(1);
  }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-4000 {
  animation-delay: 4s;
}

.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>