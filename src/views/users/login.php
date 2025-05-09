<div class="max-w-md mx-auto my-8">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-center text-indigo-700">Giriş Yap</h2>
        
        <form action="<?= url('/login/submit') ?>" method="post">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium mb-2">Kullanıcı Adı veya E-posta:</label>
                <input type="text" name="username" id="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-medium mb-2">Şifre:</label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500" onclick="togglePasswordVisibility('password')">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="mb-4">
                <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-indigo-700 transition duration-300">Giriş Yap</button>
            </div>
        </form>
        
        <div class="text-center text-gray-600">
            <p>Hesabınız yok mu? <a href="<?= url('/register') ?>" class="text-indigo-600 hover:underline">Kayıt Ol</a></p>
        </div>
    </div>
</div>

<style>
.auth-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 2rem 0;
}

.auth-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    width: 100%;
    max-width: 400px;
}

.auth-card h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: var(--primary-color);
}

.btn-block {
    width: 100%;
}

.auth-links {
    text-align: center;
    margin-top: 1.5rem;
}

.password-input-container {
    position: relative;
    display: flex;
    align-items: center;
}

.password-toggle-btn {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 0;
    font-size: 16px;
}

.password-toggle-btn:focus {
    outline: none;
}
</style>

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