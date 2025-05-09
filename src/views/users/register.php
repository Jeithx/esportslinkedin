<div class="max-w-md mx-auto my-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Kayıt Ol</h2>
        
        <form action="<?= url('/register/submit') ?>" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Kullanıcı Adı:</label>
                <input type="text" name="username" id="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                <small class="text-gray-500 text-sm mt-1 block">En az 3 karakter, özel karakter içermemeli</small>
            </div>
            
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium mb-2">E-posta:</label>
                <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium mb-2">Şifre:</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" onclick="togglePasswordVisibility('password')">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                <small class="text-gray-500 text-sm mt-1 block">En az 6 karakter</small>
            </div>
            
            <div class="mb-6">
                <label for="password_confirm" class="block text-gray-700 font-medium mb-2">Şifre Tekrar:</label>
                <div class="relative">
                    <input type="password" name="password_confirm" id="password_confirm" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" onclick="togglePasswordVisibility('password_confirm')">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="mb-4">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">Kayıt Ol</button>
            </div>
        </form>
        
        <div class="text-center text-gray-600">
            <p>Zaten hesabınız var mı? <a href="<?= url('/login') ?>" class="text-indigo-600 hover:underline">Giriş Yap</a></p>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility(inputId) {
    const passwordInput = document.getElementById(inputId);
    const icon = event.currentTarget.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>