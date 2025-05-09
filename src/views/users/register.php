<div class="auth-container">
    <div class="auth-card">
        <h2>Kayıt Ol</h2>
        
        <form action="<?= url('/register/submit') ?>" method="post">
            <div class="form-group">
                <label for="username">Kullanıcı Adı:</label>
                <input type="text" name="username" id="username" class="form-control" required>
                <small class="form-text text-muted">En az 3 karakter, özel karakter içermemeli</small>
            </div>
            
            <div class="form-group">
                <label for="email">E-posta:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="password">Şifre:</label>
                <div class="password-input-container">
                    <input type="password" name="password" id="password" class="form-control" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password')">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
                <small class="form-text text-muted">En az 6 karakter</small>
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Şifre Tekrar:</label>
                <div class="password-input-container">
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                    <button type="button" class="password-toggle-btn" onclick="togglePasswordVisibility('password_confirm')">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Kayıt Ol</button>
            </div>
        </form>
        
        <div class="auth-links">
            <p>Zaten hesabınız var mı? <a href="<?= url('/login') ?>">Giriş Yap</a></p>
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