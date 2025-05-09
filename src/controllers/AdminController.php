<?php
class AdminController {
    // Admin paneli ana sayfası
    public function index() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // İstatistikleri getir
        $userCount = $database->fetch("SELECT COUNT(*) as count FROM users")['count'];
        $teamCount = $database->fetch("SELECT COUNT(*) as count FROM teams")['count'];
        $tournamentCount = $database->fetch("SELECT COUNT(*) as count FROM tournaments")['count'];
        $activeRegistrations = $database->fetch(
            "SELECT COUNT(*) as count FROM tournament_teams WHERE status = 'pending'"
        )['count'];
        
        // Onay bekleyen son kayıtlar - "to" yerine "t" kullan
        $pendingRegistrations = $database->fetchAll(
            "SELECT tt.*, t.name as team_name, trn.name as tournament_name
            FROM tournament_teams tt
            JOIN teams t ON tt.team_id = t.id
            JOIN tournaments trn ON tt.tournament_id = trn.id
            WHERE tt.status = 'pending'
            ORDER BY tt.created_at DESC
            LIMIT 5"
        );
        
        // Son kullanıcılar
        $recentUsers = $database->fetchAll(
            "SELECT * FROM users ORDER BY created_at DESC LIMIT 5"
        );
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Admin Paneli',
            'userCount' => $userCount,
            'teamCount' => $teamCount,
            'tournamentCount' => $tournamentCount,
            'activeRegistrations' => $activeRegistrations,
            'pendingRegistrations' => $pendingRegistrations,
            'recentUsers' => $recentUsers
        ];
        
        // Admin panel görünümünü göster
        ob_start();
        view('admin/index', $data);
        $content = ob_get_clean();
        
        view('layouts/admin', ['content' => $content]);
    }
    
    // Turnuva yönetimi
    public function tournaments() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // Tüm turnuvaları getir
        $tournaments = $database->fetchAll(
            "SELECT t.*, g.name as game_name, 
                (SELECT COUNT(*) FROM tournament_teams WHERE tournament_id = t.id) as team_count
            FROM tournaments t
            JOIN games g ON t.game_id = g.id
            ORDER BY t.created_at DESC"
        );
        
        // Oyunları getir (yeni turnuva oluşturmak için)
        $games = $database->fetchAll(
            "SELECT * FROM games ORDER BY name ASC"
        );
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Turnuva Yönetimi',
            'tournaments' => $tournaments,
            'games' => $games
        ];
        
        // Turnuva yönetim görünümünü göster
        ob_start();
        view('admin/tournaments', $data);
        $content = ob_get_clean();
        
        view('layouts/admin', ['content' => $content]);
    }
    
    // Takım yönetimi
    public function teams() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // Tüm takımları getir
        $teams = $database->fetchAll(
            "SELECT t.*, u.username as owner_username,
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count
            FROM teams t
            JOIN users u ON t.owner_id = u.id
            ORDER BY t.created_at DESC"
        );
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Takım Yönetimi',
            'teams' => $teams
        ];
        
        // Takım yönetim görünümünü göster
        ob_start();
        view('admin/teams', $data);
        $content = ob_get_clean();
        
        view('layouts/admin', ['content' => $content]);
    }
    
    // Kullanıcı yönetimi
    public function users() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // Tüm kullanıcıları getir
        $users = $database->fetchAll(
            "SELECT * FROM users ORDER BY created_at DESC"
        );
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Kullanıcı Yönetimi',
            'users' => $users
        ];
        
        // Kullanıcı yönetim görünümünü göster
        ob_start();
        view('admin/users', $data);
        $content = ob_get_clean();
        
        view('layouts/admin', ['content' => $content]);
    }
    
    // Turnuva kayıt onaylama
    public function approveRegistration() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $registrationId = isset($_POST['registration_id']) ? (int)$_POST['registration_id'] : 0;
        
        if (!$registrationId) {
            Session::setFlash('error', 'Geçersiz kayıt ID\'si.');
            redirect('/admin');
            return;
        }
        
        // Kaydı güncelle
        $result = $database->update('tournament_teams', 
            ['status' => 'approved'], 
            ['id' => $registrationId]
        );
        
        if ($result) {
            Session::setFlash('success', 'Takım kaydı başarıyla onaylandı.');
        } else {
            Session::setFlash('error', 'Kayıt onaylanırken bir hata oluştu.');
        }
        
        redirect('/admin');
    }
    
    // Turnuva kayıt reddetme
    public function rejectRegistration() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $registrationId = isset($_POST['registration_id']) ? (int)$_POST['registration_id'] : 0;
        
        if (!$registrationId) {
            Session::setFlash('error', 'Geçersiz kayıt ID\'si.');
            redirect('/admin');
            return;
        }
        
        // Kaydı güncelle
        $result = $database->update('tournament_teams', 
            ['status' => 'rejected'], 
            ['id' => $registrationId]
        );
        
        if ($result) {
            Session::setFlash('success', 'Takım kaydı başarıyla reddedildi.');
        } else {
            Session::setFlash('error', 'Kayıt reddedilirken bir hata oluştu.');
        }
        
        redirect('/admin');
    }
    
    // Yeni turnuva oluşturma
    public function createTournament() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $gameId = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : null;
        $registrationStart = isset($_POST['registration_start']) ? $_POST['registration_start'] : '';
        $registrationEnd = isset($_POST['registration_end']) ? $_POST['registration_end'] : '';
        $teamLimit = isset($_POST['team_limit']) ? (int)$_POST['team_limit'] : 16;
        $prizePool = isset($_POST['prize_pool']) ? (float)$_POST['prize_pool'] : 0;
        $format = isset($_POST['format']) ? $_POST['format'] : 'single_elimination';
        $rules = isset($_POST['rules']) ? trim($_POST['rules']) : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 'draft';
        
        // Form doğrulama
        $validation = new Validation($_POST);
        $validation->required('name', 'Turnuva adı gereklidir.')
                   ->minLength('name', 3, 'Turnuva adı en az 3 karakter olmalıdır.')
                   ->maxLength('name', 100, 'Turnuva adı en fazla 100 karakter olmalıdır.')
                   ->required('game_id', 'Oyun seçimi gereklidir.')
                   ->required('start_date', 'Başlangıç tarihi gereklidir.')
                   ->required('registration_start', 'Kayıt başlangıç tarihi gereklidir.')
                   ->required('registration_end', 'Kayıt bitiş tarihi gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/admin/tournaments');
            return;
        }
        
        // Slug oluştur
        $slug = strtolower(str_replace(' ', '-', $name));
        $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        
        // Banner yükleme (varsa)
        $banner = '';
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            $bannerTmpName = $_FILES['banner']['tmp_name'];
            $bannerName = $_FILES['banner']['name'];
            $bannerExt = strtolower(pathinfo($bannerName, PATHINFO_EXTENSION));
            
            // İzin verilen uzantılar
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($bannerExt, $allowedExt)) {
                $bannerNewName = $slug . '-' . time() . '.' . $bannerExt;
                $uploadPath = ROOT_PATH . '/public/uploads/tournament_banners/';
                
                // Klasör yoksa oluştur
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                if (move_uploaded_file($bannerTmpName, $uploadPath . $bannerNewName)) {
                    $banner = $bannerNewName;
                }
            }
        }
        
        // Turnuvayı oluştur
        $tournamentId = $database->insert('tournaments', [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'game_id' => $gameId,
            'banner' => $banner,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'registration_start' => $registrationStart,
            'registration_end' => $registrationEnd,
            'team_limit' => $teamLimit,
            'prize_pool' => $prizePool,
            'format' => $format,
            'rules' => $rules,
            'status' => $status
        ]);
        
        if ($tournamentId) {
            Session::setFlash('success', 'Turnuva başarıyla oluşturuldu.');
            redirect('/admin/tournaments');
        } else {
            Session::setFlash('error', 'Turnuva oluşturulurken bir hata oluştu.');
            redirect('/admin/tournaments');
        }
    }
    // Turnuva durumu güncelleme
    public function updateTournamentStatus() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $tournamentId = isset($_POST['tournament_id']) ? (int)$_POST['tournament_id'] : 0;
        $status = isset($_POST['status']) ? $_POST['status'] : '';
        
        // Doğrulama
        if (!$tournamentId || empty($status)) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz turnuva ID veya durum.']);
            return;
        }
        
        // Geçerli durumlar
        $validStatuses = ['draft', 'registration', 'active', 'completed', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz durum.']);
            return;
        }
        
        // Turnuvayı güncelle
        $result = $database->update('tournaments', 
            ['status' => $status], 
            ['id' => $tournamentId]
        );
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Turnuva güncellenirken bir hata oluştu.']);
        }
    }

    // Turnuva silme
    public function deleteTournament() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $tournamentId = isset($_POST['tournament_id']) ? (int)$_POST['tournament_id'] : 0;
        
        if (!$tournamentId) {
            Session::setFlash('error', 'Geçersiz turnuva ID\'si.');
            redirect('/admin/tournaments');
            return;
        }
        
        // Turnuvayı sil
        $result = $database->delete('tournaments', ['id' => $tournamentId]);
        
        if ($result) {
            Session::setFlash('success', 'Turnuva başarıyla silindi.');
        } else {
            Session::setFlash('error', 'Turnuva silinirken bir hata oluştu.');
        }
        
        redirect('/admin/tournaments');
    }

    // Turnuva eşleşmelerini oluştur
    public function generateMatches() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $tournamentId = isset($_POST['tournament_id']) ? (int)$_POST['tournament_id'] : 0;
        
        if (!$tournamentId) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz turnuva ID\'si.']);
            return;
        }
        
        // Turnuva bilgilerini getir
        $tournament = $database->fetch(
            "SELECT * FROM tournaments WHERE id = ?",
            [$tournamentId]
        );
        
        if (!$tournament) {
            echo json_encode(['success' => false, 'message' => 'Turnuva bulunamadı.']);
            return;
        }
        
        // Turnuva aktif değilse
        if ($tournament['status'] !== 'active') {
            echo json_encode(['success' => false, 'message' => 'Turnuva aktif değil.']);
            return;
        }
        
        // Katılan takımları getir
        $teams = $database->fetchAll(
            "SELECT tt.team_id, t.name 
            FROM tournament_teams tt
            JOIN teams t ON tt.team_id = t.id
            WHERE tt.tournament_id = ? AND tt.status = 'approved'
            ORDER BY tt.id ASC",
            [$tournamentId]
        );
        
        if (count($teams) < 2) {
            echo json_encode(['success' => false, 'message' => 'Turnuva için en az 2 takım gereklidir.']);
            return;
        }
        
        // Eşleşme oluşturma şimdilik basit bir şekilde yapılacak
        // Tek eleme turnuvası formatı için temel eşleşmeler
        
        // Var olan maçları temizle
        $database->delete('matches', ['tournament_id' => $tournamentId]);
        
        // Takımları karıştır
        shuffle($teams);
        
        // İlk tur maçlarını oluştur
        $matchNumber = 1;
        $teamCount = count($teams);
        $matchCount = intdiv($teamCount, 2);
        
        for ($i = 0; $i < $matchCount; $i++) {
            $team1Id = $teams[$i * 2]['team_id'];
            $team2Id = isset($teams[$i * 2 + 1]) ? $teams[$i * 2 + 1]['team_id'] : null;
            
            $database->insert('matches', [
                'tournament_id' => $tournamentId,
                'round' => 1,
                'match_number' => $matchNumber,
                'team1_id' => $team1Id,
                'team2_id' => $team2Id,
                'status' => 'pending'
            ]);
            
            $matchNumber++;
        }
        
        // Diğer turlar için boş maçlar oluştur
        $round = 2;
        $remainingMatches = $matchCount / 2;
        
        while ($remainingMatches >= 1) {
            for ($i = 1; $i <= $remainingMatches; $i++) {
                $database->insert('matches', [
                    'tournament_id' => $tournamentId,
                    'round' => $round,
                    'match_number' => $i,
                    'status' => 'pending'
                ]);
            }
            
            $round++;
            $remainingMatches = $remainingMatches / 2;
        }
        
        echo json_encode(['success' => true]);
    }

    // Takım silme
    public function deleteTeam() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $teamId = isset($_POST['team_id']) ? (int)$_POST['team_id'] : 0;
        
        if (!$teamId) {
            Session::setFlash('error', 'Geçersiz takım ID\'si.');
            redirect('/admin/teams');
            return;
        }
        
        // Takımı sil
        $result = $database->delete('teams', ['id' => $teamId]);
        
        if ($result) {
            Session::setFlash('success', 'Takım başarıyla silindi.');
        } else {
            Session::setFlash('error', 'Takım silinirken bir hata oluştu.');
        }
        
        redirect('/admin/teams');
    }

    // Kullanıcı silme
    public function deleteUser() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        
        if (!$userId) {
            Session::setFlash('error', 'Geçersiz kullanıcı ID\'si.');
            redirect('/admin/users');
            return;
        }
        
        // Kullanıcıyı sil
        $result = $database->delete('users', ['id' => $userId]);
        
        if ($result) {
            Session::setFlash('success', 'Kullanıcı başarıyla silindi.');
        } else {
            Session::setFlash('error', 'Kullanıcı silinirken bir hata oluştu.');
        }
        
        redirect('/admin/users');
    }

    // Kullanıcı rolü güncelleme
    public function updateUserRole() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
        $role = isset($_POST['role']) ? $_POST['role'] : '';
        
        // Doğrulama
        if (!$userId || empty($role)) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz kullanıcı ID veya rol.']);
            return;
        }
        
        // Geçerli roller
        $validRoles = ['user', 'admin'];
        if (!in_array($role, $validRoles)) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz rol.']);
            return;
        }
        
        // Kullanıcıyı güncelle
        $result = $database->update('users', 
            ['role' => $role], 
            ['id' => $userId]
        );
        
        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Kullanıcı güncellenirken bir hata oluştu.']);
        }
    }   

        // Turnuva düzenleme sayfası
    public function editTournament() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // Turnuva ID'sini al
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            Session::setFlash('error', 'Geçersiz turnuva ID\'si.');
            redirect('/admin/tournaments');
            return;
        }
        
        // Turnuva bilgilerini getir
        $tournament = $database->fetch(
            "SELECT * FROM tournaments WHERE id = ?",
            [$id]
        );
        
        if (!$tournament) {
            Session::setFlash('error', 'Turnuva bulunamadı.');
            redirect('/admin/tournaments');
            return;
        }
        
        // Oyunları getir
        $games = $database->fetchAll(
            "SELECT * FROM games ORDER BY name ASC"
        );
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Turnuva Düzenle: ' . $tournament['name'],
            'tournament' => $tournament,
            'games' => $games
        ];
        
        // Turnuva düzenleme görünümünü göster
        ob_start();
        view('admin/edit_tournament', $data);
        $content = ob_get_clean();
        
        view('layouts/admin', ['content' => $content, 'pageTitle' => $data['pageTitle']]);
    }

    // Turnuva güncelleme işlemi
    public function updateTournament() {
        global $database;
        
        // Admin yetkisi kontrolü
        Auth::requireAdmin();
        
        // POST verilerini al
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $gameId = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
        $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : null;
        $registrationStart = isset($_POST['registration_start']) ? $_POST['registration_start'] : '';
        $registrationEnd = isset($_POST['registration_end']) ? $_POST['registration_end'] : '';
        $teamLimit = isset($_POST['team_limit']) ? (int)$_POST['team_limit'] : 16;
        $prizePool = isset($_POST['prize_pool']) ? (float)$_POST['prize_pool'] : 0;
        $format = isset($_POST['format']) ? $_POST['format'] : 'single_elimination';
        $rules = isset($_POST['rules']) ? trim($_POST['rules']) : '';
        $status = isset($_POST['status']) ? $_POST['status'] : 'draft';
        
        // Form doğrulama
        $validation = new Validation($_POST);
        $validation->required('id', 'Turnuva ID\'si gereklidir.')
                ->required('name', 'Turnuva adı gereklidir.')
                ->minLength('name', 3, 'Turnuva adı en az 3 karakter olmalıdır.')
                ->maxLength('name', 100, 'Turnuva adı en fazla 100 karakter olmalıdır.')
                ->required('game_id', 'Oyun seçimi gereklidir.')
                ->required('start_date', 'Başlangıç tarihi gereklidir.')
                ->required('registration_start', 'Kayıt başlangıç tarihi gereklidir.')
                ->required('registration_end', 'Kayıt bitiş tarihi gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/admin/tournaments/edit?id=' . $id);
            return;
        }
        
        // Turnuva bilgilerini getir
        $tournament = $database->fetch(
            "SELECT * FROM tournaments WHERE id = ?",
            [$id]
        );
        
        if (!$tournament) {
            Session::setFlash('error', 'Turnuva bulunamadı.');
            redirect('/admin/tournaments');
            return;
        }
        
        // Slug oluştur (mevcut değilse)
        $slug = $tournament['slug'];
        if (empty($slug) || $name !== $tournament['name']) {
            $slug = strtolower(str_replace(' ', '-', $name));
            $slug = preg_replace('/[^a-z0-9\-]/', '', $slug);
        }
        
        // Banner yükleme (varsa)
        $banner = $tournament['banner'];
        if (isset($_FILES['banner']) && $_FILES['banner']['error'] === UPLOAD_ERR_OK) {
            $bannerTmpName = $_FILES['banner']['tmp_name'];
            $bannerName = $_FILES['banner']['name'];
            $bannerExt = strtolower(pathinfo($bannerName, PATHINFO_EXTENSION));
            
            // İzin verilen uzantılar
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($bannerExt, $allowedExt)) {
                $bannerNewName = $slug . '-' . time() . '.' . $bannerExt;
                $uploadPath = ROOT_PATH . '/public/uploads/tournament_banners/';
                
                // Klasör yoksa oluştur
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                if (move_uploaded_file($bannerTmpName, $uploadPath . $bannerNewName)) {
                    // Eski banner'ı sil (varsa)
                    if (!empty($banner) && file_exists($uploadPath . $banner)) {
                        unlink($uploadPath . $banner);
                    }
                    
                    $banner = $bannerNewName;
                }
            }
        }
        
        // Turnuvayı güncelle
        $updateData = [
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'game_id' => $gameId,
            'banner' => $banner,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'registration_start' => $registrationStart,
            'registration_end' => $registrationEnd,
            'team_limit' => $teamLimit,
            'prize_pool' => $prizePool,
            'format' => $format,
            'rules' => $rules,
            'status' => $status
        ];
        
        $result = $database->update('tournaments', $updateData, ['id' => $id]);
        
        if ($result) {
            Session::setFlash('success', 'Turnuva başarıyla güncellendi.');
            redirect('/admin/tournaments');
        } else {
            Session::setFlash('error', 'Turnuva güncellenirken bir hata oluştu.');
            redirect('/admin/tournaments/edit?id=' . $id);
        }
    }
}