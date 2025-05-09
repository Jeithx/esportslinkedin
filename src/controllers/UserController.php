<?php
class UserController {
    // Kayıt sayfası
    public function register() {
        // Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
        if (Auth::isLoggedIn()) {
            redirect('');
            return;
        }
        
        // Kayıt sayfası görünümünü göster
        $data = [
            'pageTitle' => 'Kayıt Ol'
        ];
        
        ob_start();
        view('users/register', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Kayıt işlemi
    public function registerSubmit() {
        global $database;
        
        // Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
        if (Auth::isLoggedIn()) {
            redirect('');
            return;
        }
        
        // POST verilerini al
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        $passwordConfirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
        
        // Form doğrulama
        $validation = new Validation($_POST);
        $validation->required('username', 'Kullanıcı adı gereklidir.')
                   ->minLength('username', 3, 'Kullanıcı adı en az 3 karakter olmalıdır.')
                   ->maxLength('username', 50, 'Kullanıcı adı en fazla 50 karakter olmalıdır.')
                   ->required('email', 'E-posta adresi gereklidir.')
                   ->email('email', 'Geçerli bir e-posta adresi giriniz.')
                   ->required('password', 'Şifre gereklidir.')
                   ->minLength('password', 6, 'Şifre en az 6 karakter olmalıdır.')
                   ->required('password_confirm', 'Şifre onayı gereklidir.')
                   ->matches('password', 'password_confirm', 'Şifreler eşleşmiyor.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('register');
            return;
        }
        
        // Kullanıcı adı ve e-posta benzersizliğini kontrol et
        $existingUser = $database->fetch(
            "SELECT * FROM users WHERE username = ? OR email = ?",
            [$username, $email]
        );
        
        if ($existingUser) {
            if ($existingUser['username'] === $username) {
                Session::setFlash('error', 'Bu kullanıcı adı zaten kullanılıyor.');
            } else {
                Session::setFlash('error', 'Bu e-posta adresi zaten kullanılıyor.');
            }
            redirect('register');
            return;
        }
        
        // Şifreyi hashle
        $hashedPassword = Auth::hashPassword($password);
        
        // Kullanıcıyı oluştur
        $userId = $database->insert('users', [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => 'user'
        ]);
        
        if ($userId) {
            Session::setFlash('success', 'Kayıt işlemi başarılı. Şimdi giriş yapabilirsiniz.');
            redirect('login');
        } else {
            Session::setFlash('error', 'Kayıt sırasında bir hata oluştu.');
            redirect('register');
        }
    }
    
    // Giriş sayfası
    public function login() {
        // Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
        if (Auth::isLoggedIn()) {
            redirect('');
            return;
        }
        
        // Giriş sayfası görünümünü göster
        $data = [
            'pageTitle' => 'Giriş Yap'
        ];
        
        ob_start();
        view('users/login', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Giriş işlemi
    public function loginSubmit() {
        global $database;
        
        // Kullanıcı zaten giriş yapmışsa ana sayfaya yönlendir
        if (Auth::isLoggedIn()) {
            redirect('');
            return;
        }
        
        // POST verilerini al
        $username = isset($_POST['username']) ? trim($_POST['username']) : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        
        // Form doğrulama
        $validation = new Validation($_POST);
        $validation->required('username', 'Kullanıcı adı veya e-posta gereklidir.')
                   ->required('password', 'Şifre gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('login');
            return;
        }
        
        // Kullanıcıyı kontrol et (kullanıcı adı veya e-posta ile)
        $user = $database->fetch(
            "SELECT * FROM users WHERE username = ? OR email = ?",
            [$username, $username]
        );
        
        if (!$user || !Auth::verifyPassword($password, $user['password'])) {
            Session::setFlash('error', 'Geçersiz kullanıcı adı/e-posta veya şifre.');
            redirect('login');
            return;
        }
        
        // Kullanıcı girişi yap
        Auth::login($user);
        
        Session::setFlash('success', 'Başarıyla giriş yaptınız.');
        redirect('');
    }
    
    // Çıkış işlemi
    public function logout() {
        // Kullanıcı çıkışı yap
        Auth::logout();
        
        Session::setFlash('success', 'Başarıyla çıkış yaptınız.');
        redirect('');
    }
   

// Profil sayfası
public function profile() {
    global $database;
    
    // Kullanıcı girişi kontrolü
    Auth::requireLogin();
    
    // Kullanıcı bilgilerini getir
    $userId = Session::get('user_id');
    $user = $database->fetch(
        "SELECT * FROM users WHERE id = ?",
        [$userId]
    );
    
    // Kullanıcının takımlarını getir
    $teams = $database->fetchAll(
        "SELECT t.*, tm.role as team_role
        FROM teams t
        JOIN team_members tm ON t.id = tm.team_id
        WHERE tm.user_id = ?
        ORDER BY t.name ASC",
        [$userId]
    );
    
    // Kullanıcının turnuvalarını getir (takımları üzerinden)
    $tournaments = $database->fetchAll(
        "SELECT DISTINCT t.*, g.name as game_name
        FROM tournaments t
        JOIN tournament_teams tt ON t.id = tt.tournament_id
        JOIN teams tm ON tt.team_id = tm.id
        JOIN team_members tmu ON tm.id = tmu.team_id
        JOIN games g ON t.game_id = g.id
        WHERE tmu.user_id = ?
        ORDER BY t.start_date DESC",
        [$userId]
    );
    
    // Görünüm verilerini hazırla
    $data = [
        'pageTitle' => 'Profilim',
        'user' => $user,
        'teams' => $teams,
        'tournaments' => $tournaments
    ];
    
    // Profil görünümünü göster
    ob_start();
    view('users/profile', $data);
    $content = ob_get_clean();
    
    view('layouts/main', ['content' => $content]);
}

// Profil güncelleme
// Profil güncelleme
public function updateProfile() {
    global $database;
    
    // Kullanıcı girişi kontrolü
    Auth::requireLogin();
    
    // POST verilerini al
    $fullName = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $bio = isset($_POST['bio']) ? trim($_POST['bio']) : '';
    $gameId = isset($_POST['game_id']) ? trim($_POST['game_id']) : '';
    $discord = isset($_POST['discord']) ? trim($_POST['discord']) : '';
    $currentPassword = isset($_POST['current_password']) ? $_POST['current_password'] : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $newPasswordConfirm = isset($_POST['new_password_confirm']) ? $_POST['new_password_confirm'] : '';
    
    // Kullanıcı bilgilerini getir
    $userId = Session::get('user_id');
    $user = $database->fetch(
        "SELECT * FROM users WHERE id = ?",
        [$userId]
    );
    
    // Form doğrulama
    $validation = new Validation($_POST);
    $validation->required('email', 'E-posta adresi gereklidir.')
               ->email('email', 'Geçerli bir e-posta adresi giriniz.');
    
    // E-posta değiştiyse benzersizliği kontrol et
    if ($email !== $user['email']) {
        $existingEmail = $database->fetch(
            "SELECT * FROM users WHERE email = ? AND id != ?",
            [$email, $userId]
        );
        
        if ($existingEmail) {
            Session::setFlash('error', 'Bu e-posta adresi zaten kullanılıyor.');
            redirect('/profile');
            return;
        }
    }
    
    // Şifre değişikliği istendiyse kontrol et
    if (!empty($newPassword)) {
        // Mevcut şifre kontrolü
        if (empty($currentPassword) || !Auth::verifyPassword($currentPassword, $user['password'])) {
            Session::setFlash('error', 'Mevcut şifre yanlış.');
            redirect('/profile');
            return;
        }
        
        // Yeni şifre doğrulama
        $validation->minLength('new_password', 6, 'Yeni şifre en az 6 karakter olmalıdır.')
                   ->matches('new_password', 'new_password_confirm', 'Yeni şifreler eşleşmiyor.');
    }
    
    if ($validation->fails()) {
        Session::setFlash('error', $validation->getFirstError());
        redirect('/profile');
        return;
    }
    
    // Avatar yükleme (varsa)
    $avatar = $user['avatar'];
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatarTmpName = $_FILES['avatar']['tmp_name'];
        $avatarName = $_FILES['avatar']['name'];
        $avatarExt = strtolower(pathinfo($avatarName, PATHINFO_EXTENSION));
        
        // İzin verilen uzantılar
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($avatarExt, $allowedExt)) {
            $avatarNewName = 'user-' . $userId . '-' . time() . '.' . $avatarExt;
            $uploadPath = ROOT_PATH . '/public/uploads/avatars/';
            
            // Klasör yoksa oluştur
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            if (move_uploaded_file($avatarTmpName, $uploadPath . $avatarNewName)) {
                // Eski avatarı sil (default dışındaysa)
                if ($avatar && $avatar !== 'default.png' && file_exists($uploadPath . $avatar)) {
                    unlink($uploadPath . $avatar);
                }
                
                $avatar = $avatarNewName;
            }
        }
    }
    
    // Güncelleme verilerini hazırla
    $updateData = [
        'full_name' => $fullName,
        'email' => $email,
        'bio' => $bio,
        'game_id' => $gameId,
        'discord' => $discord,
        'avatar' => $avatar
    ];
    
    // Şifre değişikliği varsa ekle
    if (!empty($newPassword)) {
        $updateData['password'] = Auth::hashPassword($newPassword);
    }
    
    // Kullanıcı bilgilerini güncelle
    $result = $database->update('users', $updateData, ['id' => $userId]);
    
    if ($result) {
        // Oturum bilgilerini güncelle
        Session::set('user_email', $email);
        
        Session::setFlash('success', 'Profil bilgileriniz başarıyla güncellendi.');
    } else {
        Session::setFlash('error', 'Profil güncellenirken bir hata oluştu.');
    }
    
    redirect('/profile');
}
}