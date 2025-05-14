<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="<?= url('/teams') ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Takımlara Dön
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 py-6 px-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Yeni Takım Oluştur</h1>
            <p class="text-indigo-100 mt-2">Kendi e-spor takımını kur ve turnuvalara katıl</p>
        </div>
        
        <form action="<?= url('/teams/create/submit') ?>" method="post" enctype="multipart/form-data" class="p-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Sol kolon: Temel Bilgiler -->
                <div class="lg:col-span-2 space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Takım Adı <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
                        <p class="mt-1 text-sm text-gray-500">Takım adı benzersiz olmalıdır (3-50 karakter)</p>
                    </div>
                    
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Takım Açıklaması</label>
                        <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        <p class="mt-1 text-sm text-gray-500">Takımınızı kısaca tanıtın, oyun stilinizi ve hedeflerinizi belirtin</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ana Oyun</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="main_game" value="lol" class="sr-only peer">
                                <div class="p-3 border-2 rounded-lg border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex flex-col items-center">
                                        <img src="<?= url('/assets/images/games/lol.png') ?>" class="w-10 h-10 mb-1" alt="League of Legends"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/40/4F46E5/ffffff?text=LoL';">
                                        <span class="text-sm font-medium">LoL</span>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative cursor-pointer">
                                <input type="radio" name="main_game" value="valorant" class="sr-only peer">
                                <div class="p-3 border-2 rounded-lg border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex flex-col items-center">
                                        <img src="<?= url('/assets/images/games/valorant.png') ?>" class="w-10 h-10 mb-1" alt="Valorant"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/40/EF4444/ffffff?text=V';">
                                        <span class="text-sm font-medium">Valorant</span>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative cursor-pointer">
                                <input type="radio" name="main_game" value="cs2" class="sr-only peer">
                                <div class="p-3 border-2 rounded-lg border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex flex-col items-center">
                                        <img src="<?= url('/assets/images/games/cs2.png') ?>" class="w-10 h-10 mb-1" alt="CS2"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/40/1F2937/ffffff?text=CS2';">
                                        <span class="text-sm font-medium">CS2</span>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="relative cursor-pointer">
                                <input type="radio" name="main_game" value="r6" class="sr-only peer">
                                <div class="p-3 border-2 rounded-lg border-gray-200 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex flex-col items-center">
                                        <img src="<?= url('/assets/images/games/r6.png') ?>" class="w-10 h-10 mb-1" alt="Rainbow Six"
                                             onerror="this.onerror=null; this.src='https://via.placeholder.com/40/F59E0B/ffffff?text=R6';">
                                        <span class="text-sm font-medium">R6 Siege</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="discord" class="block text-sm font-medium text-gray-700 mb-1">Discord Sunucusu</label>
                        <input type="text" name="discord" id="discord" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <p class="mt-1 text-sm text-gray-500">Takım Discord sunucunuz varsa, davet bağlantısını ekleyin</p>
                    </div>
                </div>
                
                <!-- Sağ kolon: Logo ve Diğer Bilgiler -->
                <div class="space-y-6">
                    <div>
                        <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Takım Logosu</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                            <div class="space-y-1 text-center">
                                <div class="mx-auto h-32 w-32 flex items-center justify-center" id="logo-preview">
                                    <svg class="h-20 w-20 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="flex text-sm text-gray-600">
                                    <label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Logo Yükle</span>
                                        <input id="logo" name="logo" type="file" class="sr-only" accept="image/*" onchange="previewLogo(event)">
                                    </label>
                                    <p class="pl-1">veya sürükle bırak</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF (500x500px önerilir)</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                        <h3 class="font-medium text-indigo-800 mb-2">Takım Kaptanı</h3>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (!empty(Session::get('user_avatar'))): ?>
                                    <img class="h-10 w-10 rounded-full" src="<?= url('/uploads/avatars/' . Session::get('user_avatar')) ?>" alt="<?= escape(Session::get('user_name')) ?>">
                                <?php else: ?>
                                    <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white text-sm font-medium">
                                        <?= strtoupper(substr(Session::get('user_name'), 0, 2)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900"><?= escape(Session::get('user_name')) ?></p>
                                <p class="text-sm text-gray-500"><?= escape(Session::get('user_email')) ?></p>
                            </div>
                        </div>
                        <p class="mt-2 text-sm text-indigo-700">Sen bu takımın kaptanı olacaksın. Takım üyelerini davet edebilir ve yönetebilirsin.</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-5 border-t border-gray-200">
                <div class="flex justify-end">
                    <a href="<?= url('/teams') ?>" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        İptal
                    </a>
                    <button type="submit" class="ml-3 inline-flex justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Takımı Oluştur
                    </button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Takım Oluşturma İpuçları</h2>
        <ul class="space-y-3">
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Takımın için profesyonel ve orijinal bir isim seç.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Takım açıklamanı doldurarak takımının değerlerini ve hedeflerini belirt.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Takımının tanınırlığını artırmak için kaliteli bir logo yükle.</span>
            </li>
            <li class="flex items-start">
                <svg class="h-5 w-5 text-green-500 mr-2 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-gray-600">Takımını oluşturduktan sonra yetenekli oyuncuları davet etmeyi unutma.</span>
            </li>
        </ul>
    </div>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewDiv = document.getElementById('logo-preview');
                
                // Mevcut içeriği temizle
                previewDiv.innerHTML = '';
                
                // Yeni resmi ekle
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'h-32 w-32 object-contain';
                img.alt = 'Takım Logosu Önizleme';
                
                previewDiv.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Ana oyun seçimi için tüm radio etiketleri
    const gameOptions = document.querySelectorAll('[name="main_game"]');
    
    // Her etiket için olay dinleyicisi ekle
    gameOptions.forEach(option => {
        const container = option.closest('.relative');
        
        container.addEventListener('click', function() {
            // Önce tüm seçimleri temizle
            gameOptions.forEach(radio => {
                const parent = radio.closest('.relative').querySelector('.p-3');
                parent.classList.remove('border-indigo-500', 'bg-indigo-50');
                parent.classList.add('border-gray-200');
                radio.checked = false;
            });
            
            // Tıklanan öğeyi seç
            option.checked = true;
            const selectedDiv = container.querySelector('.p-3');
            selectedDiv.classList.remove('border-gray-200');
            selectedDiv.classList.add('border-indigo-500', 'bg-indigo-50');
        });
    });
});
</script>

