<?php
class TeamController {
    // Tüm takımları listeleme
    public function index() {
        global $database;
        
        // Tüm takımları getir
        $teams = $database->fetchAll(
            "SELECT * FROM teams ORDER BY name ASC"
        );
        
        // Her takımın üye sayısını getir
        foreach ($teams as &$team) {
            $memberCount = $database->fetch(
                "SELECT COUNT(*) as count FROM team_members WHERE team_id = ?",
                [$team['id']]
            );
            $team['member_count'] = $memberCount['count'];
        }
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Takımlar',
            'teams' => $teams,
            'cssFiles' => ['teams.css']
        ];
        
        // Takımlar görünümünü göster
        ob_start();
        view('teams/index', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Takım detaylarını gösterme
    public function view() {
        global $database;
        
        // Takım ID'sini al
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            Session::setFlash('error', 'Geçersiz takım ID\'si.');
            redirect('teams');
            return;
        }
        
        // Takım bilgilerini getir
        $team = $database->fetch(
            "SELECT t.*, u.username as owner_username
            FROM teams t
            JOIN users u ON t.owner_id = u.id
            WHERE t.id = ?",
            [$id]
        );
        
        if (!$team) {
            Session::setFlash('error', 'Takım bulunamadı.');
            redirect('teams');
            return;
        }
        
        // Takım üyelerini getir
        $members = $database->fetchAll(
            "SELECT u.*, tm.role as team_role
            FROM users u
            JOIN team_members tm ON u.id = tm.user_id
            WHERE tm.team_id = ?
            ORDER BY tm.role DESC, u.username ASC",
            [$id]
        );
        
        // Takımın katıldığı turnuvaları getir
        $tournaments = $database->fetchAll(
            "SELECT t.*, tt.status as registration_status, g.name as game_name
            FROM tournaments t
            JOIN tournament_teams tt ON t.id = tt.tournament_id
            JOIN games g ON t.game_id = g.id
            WHERE tt.team_id = ?
            ORDER BY t.start_date DESC",
            [$id]
        );
        
        // Kullanıcı takımın üyesi mi kontrol et
        $isMember = false;
        $isCaptain = false;
        if (Auth::isLoggedIn()) {
            $userId = Session::get('user_id');
            $memberCheck = $database->fetch(
                "SELECT * FROM team_members 
                WHERE team_id = ? AND user_id = ?",
                [$id, $userId]
            );
            
            if ($memberCheck) {
                $isMember = true;
                $isCaptain = $memberCheck['role'] === 'captain';
            }
        }
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => $team['name'],
            'team' => $team,
            'members' => $members,
            'tournaments' => $tournaments,
            'isMember' => $isMember,
            'isCaptain' => $isCaptain,
            'cssFiles' => ['teams.css'],
            'jsFiles' => ['teams.js']
        ];
        
        // Takım detay görünümünü göster
        ob_start();
        view('teams/view', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // TeamController sınıfına şu metodu ekleyin:

// Takım oluşturma formu
public function createForm() {
    // Kullanıcı girişi kontrolü
    Auth::requireLogin();
    
    // Görünüm verilerini hazırla
    $data = [
        'pageTitle' => 'Takım Oluştur',
        'cssFiles' => ['teams.css']
    ];
    
    // Takım oluşturma formunu göster
    ob_start();
    view('teams/create', $data);
    $content = ob_get_clean();
    
    view('layouts/main', ['content' => $content]);
}

// Mevcut create metodunu POST işlemi için güncelle
public function create() {
    global $database;
    
    // Kullanıcı girişi kontrolü
    Auth::requireLogin();
    
    // POST verilerini al
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $mainGame = isset($_POST['main_game']) ? trim($_POST['main_game']) : '';
    $discord = isset($_POST['discord']) ? trim($_POST['discord']) : '';
    
    // Form doğrulama
    $validation = new Validation($_POST);
    $validation->required('name', 'Takım adı gereklidir.')
               ->minLength('name', 3, 'Takım adı en az 3 karakter olmalıdır.')
               ->maxLength('name', 50, 'Takım adı en fazla 50 karakter olmalıdır.');
    
    if ($validation->fails()) {
        Session::setFlash('error', $validation->getFirstError());
        redirect('teams/create');
        return;
    }
    
    // Takım adının benzersiz olup olmadığını kontrol et
    $existingTeam = $database->fetch(
        "SELECT * FROM teams WHERE name = ?",
        [$name]
    );
    
    if ($existingTeam) {
        Session::setFlash('error', 'Bu takım adı zaten kullanılıyor.');
        redirect('teams/create');
        return;
    }
    
    // Slug oluştur
    $slug = strtolower(str_replace(' ', '-', $name));
    $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
    
    // Takım logosu yükleme (varsa)
    $logo = '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoTmpName = $_FILES['logo']['tmp_name'];
        $logoName = $_FILES['logo']['name'];
        $logoExt = strtolower(pathinfo($logoName, PATHINFO_EXTENSION));
        
        // İzin verilen uzantılar
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($logoExt, $allowedExt)) {
            $logoNewName = $slug . '-' . time() . '.' . $logoExt;
            $uploadPath = ROOT_PATH . '/public/uploads/team_logos/';
            
            // Klasör yoksa oluştur
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            if (move_uploaded_file($logoTmpName, $uploadPath . $logoNewName)) {
                $logo = $logoNewName;
            }
        }
    }
    
    // Kullanıcı ID'sini al
    $userId = Session::get('user_id');
    
    // Ana oyun bilgisini açıklamaya ekle
    if (!empty($mainGame)) {
        $description .= "\n\nAna Oyun: " . strtoupper($mainGame);
    }
    
    // Discord bilgisini açıklamaya ekle
    if (!empty($discord)) {
        $description .= "\n\nDiscord: " . $discord;
    }
    
    // Takımı oluştur
    $teamId = $database->insert('teams', [
        'name' => $name,
        'slug' => $slug,
        'description' => $description,
        'logo' => $logo,
        'owner_id' => $userId
    ]);
    
    if ($teamId) {
        // Kullanıcıyı takım kaptanı olarak ekle
        $database->insert('team_members', [
            'team_id' => $teamId,
            'user_id' => $userId,
            'role' => 'captain'
        ]);
        
        Session::setFlash('success', 'Takım başarıyla oluşturuldu.');
        redirect('teams/view?id=' . $teamId);
    } else {
        Session::setFlash('error', 'Takım oluşturulurken bir hata oluştu.');
        redirect('teams/create');
    }
}

    // Takıma üye davet etme
    public function invite() {
        global $database;
        
        // Kullanıcı girişi kontrolü
        Auth::requireLogin();
        
        // POST verilerini al
        $teamId = isset($_POST['team_id']) ? (int)$_POST['team_id'] : 0;
        $email = isset($_POST['email']) ? trim($_POST['email']) : '';
        
        // Form doğrulama
        if (empty($teamId) || empty($email)) {
            Session::setFlash('error', 'Takım ID ve e-posta adresi gereklidir.');
            redirect('/teams/view?id=' . $teamId);
            return;
        }
        
        // E-posta formatını kontrol et
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('error', 'Geçerli bir e-posta adresi giriniz.');
            redirect('/teams/view?id=' . $teamId);
            return;
        }
        
        // Kullanıcının takım kaptanı olduğunu kontrol et
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
            WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$teamId, $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları davet gönderebilir.');
            redirect('/teams/view?id=' . $teamId);
            return;
        }
        
        // Takımı kontrol et
        $team = $database->fetch(
            "SELECT * FROM teams WHERE id = ?",
            [$teamId]
        );
        
        if (!$team) {
            Session::setFlash('error', 'Takım bulunamadı.');
            redirect('/teams');
            return;
        }
        
        // E-posta ile kullanıcıyı bul
        $invitedUser = $database->fetch(
            "SELECT * FROM users WHERE email = ?",
            [$email]
        );
        
        // Kullanıcı sistemde kayıtlı mı kontrol et
        if (!$invitedUser) {
            // Burada gerçek bir senaryoda kullanıcıya e-posta gönderilir
            // Şimdilik sadece bilgilendirme mesajı gösterelim
            Session::setFlash('info', 'Bu e-posta adresi sisteme kayıtlı değil. Kullanıcıdan önce kayıt olmasını isteyebilirsiniz.');
            redirect('/teams/view?id=' . $teamId);
            return;
        }
        
        // Kullanıcı zaten takımda mı kontrol et
        $alreadyMember = $database->fetch(
            "SELECT * FROM team_members 
            WHERE team_id = ? AND user_id = ?",
            [$teamId, $invitedUser['id']]
        );
        
        if ($alreadyMember) {
            Session::setFlash('error', 'Bu kullanıcı zaten takımın üyesi.');
            redirect('/teams/view?id=' . $teamId);
            return;
        }
        
        // Daha önce davet gönderilmiş mi kontrol et (gerçek projede team_invites tablosu olabilir)
        // Basit bir çözüm olarak kullanıcıyı doğrudan ekleyelim
        $result = $database->insert('team_members', [
            'team_id' => $teamId,
            'user_id' => $invitedUser['id'],
            'role' => 'member'
        ]);
        
        if ($result) {
            Session::setFlash('success', 'Kullanıcı başarıyla takıma eklendi.');
        } else {
            Session::setFlash('error', 'Kullanıcı eklenirken bir hata oluştu.');
        }
        
        redirect('/teams/view?id=' . $teamId);
    }
}