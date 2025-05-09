<?php
class TournamentController {
    // Tüm turnuvaları listeleme
    public function index() {
        global $database;
        
        // Aktif turnuvaları getir
        $activeTournaments = $database->fetchAll(
            "SELECT t.*, g.name as game_name 
            FROM tournaments t
            JOIN games g ON t.game_id = g.id
            WHERE t.status IN ('registration', 'active') 
            ORDER BY t.start_date ASC"
        );
        
        // Yaklaşan turnuvaları getir
        $upcomingTournaments = $database->fetchAll(
            "SELECT t.*, g.name as game_name 
            FROM tournaments t
            JOIN games g ON t.game_id = g.id
            WHERE t.status = 'draft' AND t.start_date > NOW() 
            ORDER BY t.start_date ASC
            LIMIT 5"
        );
        
        // Tamamlanan turnuvaları getir
        $completedTournaments = $database->fetchAll(
            "SELECT t.*, g.name as game_name 
            FROM tournaments t
            JOIN games g ON t.game_id = g.id
            WHERE t.status = 'completed' 
            ORDER BY t.end_date DESC
            LIMIT 5"
        );
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => 'Turnuvalar',
            'activeTournaments' => $activeTournaments,
            'upcomingTournaments' => $upcomingTournaments,
            'completedTournaments' => $completedTournaments,
            'cssFiles' => ['tournaments.css']
        ];
        
        // Turnuvalar görünümünü göster
        ob_start();
        view('tournaments/index', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Turnuva detaylarını gösterme
    public function view() {
        global $database;
        
        // Turnuva ID'sini al
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            Session::setFlash('error', 'Geçersiz turnuva ID\'si.');
            redirect('tournaments');
            return;
        }
        
        // Turnuva bilgilerini getir
        $tournament = $database->fetch(
            "SELECT t.*, g.name as game_name 
            FROM tournaments t
            JOIN games g ON t.game_id = g.id
            WHERE t.id = ?",
            [$id]
        );
        
        if (!$tournament) {
            Session::setFlash('error', 'Turnuva bulunamadı.');
            redirect('tournaments');
            return;
        }
        
        // Turnuvaya katılan takımları getir
        $teams = $database->fetchAll(
            "SELECT t.*, tt.status as registration_status
            FROM teams t
            JOIN tournament_teams tt ON t.id = tt.team_id
            WHERE tt.tournament_id = ?
            ORDER BY tt.seed ASC",
            [$id]
        );
        
        // Turnuva maçlarını getir
        $matches = $database->fetchAll(
            "SELECT m.*, 
                t1.name as team1_name, t1.logo as team1_logo,
                t2.name as team2_name, t2.logo as team2_logo
            FROM matches m
            LEFT JOIN teams t1 ON m.team1_id = t1.id
            LEFT JOIN teams t2 ON m.team2_id = t2.id
            WHERE m.tournament_id = ?
            ORDER BY m.round ASC, m.match_number ASC",
            [$id]
        );
        
        // Kullanıcının takımlarını getir (eğer giriş yapmışsa)
        $userTeams = [];
        if (Auth::isLoggedIn()) {
            $userId = Session::get('user_id');
            $userTeams = $database->fetchAll(
                "SELECT t.*
                FROM teams t
                JOIN team_members tm ON t.id = tm.team_id
                WHERE tm.user_id = ? AND tm.role = 'captain'",
                [$userId]
            );
        }
        
        // Turnuvada kullanıcının takımı kayıtlı mı kontrol et
        $isTeamRegistered = false;
        if (Auth::isLoggedIn() && !empty($userTeams)) {
            $userTeamIds = array_column($userTeams, 'id');
            $teamIds = array_column($teams, 'id');
            $isTeamRegistered = count(array_intersect($userTeamIds, $teamIds)) > 0;
        }
        
        // Görünüm verilerini hazırla
        $data = [
            'pageTitle' => $tournament['name'],
            'tournament' => $tournament,
            'teams' => $teams,
            'matches' => $matches,
            'userTeams' => $userTeams,
            'isTeamRegistered' => $isTeamRegistered,
            'cssFiles' => ['tournaments.css'],
            'jsFiles' => ['tournaments.js', 'brackets.js']
        ];
        
        // Turnuva detay görünümünü göster
        ob_start();
        view('tournaments/view', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Turnuvaya takım kaydı
    public function register() {
        global $database;
        
        // Kullanıcı girişi kontrolü
        Auth::requireLogin();
        
        // POST verilerini al
        $tournamentId = isset($_POST['tournament_id']) ? (int)$_POST['tournament_id'] : 0;
        $teamId = isset($_POST['team_id']) ? (int)$_POST['team_id'] : 0;
        
        if (!$tournamentId || !$teamId) {
            Session::setFlash('error', 'Geçersiz turnuva veya takım ID\'si.');
            redirect('tournaments');
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
            Session::setFlash('error', 'Bu takımı kaydedebilmek için kaptan olmalısınız.');
            redirect('tournaments/view?id=' . $tournamentId);
            return;
        }
        
        // Turnuvanın kayıt durumunu kontrol et
        $tournament = $database->fetch(
            "SELECT * FROM tournaments WHERE id = ?",
            [$tournamentId]
        );
        
        if (!$tournament || $tournament['status'] != 'registration') {
            Session::setFlash('error', 'Bu turnuva şu anda kayıtlara açık değil.');
            redirect('tournaments/view?id=' . $tournamentId);
            return;
        }
        
        // Takımın zaten kayıtlı olup olmadığını kontrol et
        $existingRegistration = $database->fetch(
            "SELECT * FROM tournament_teams 
            WHERE tournament_id = ? AND team_id = ?",
            [$tournamentId, $teamId]
        );
        
        if ($existingRegistration) {
            Session::setFlash('error', 'Bu takım zaten turnuvaya kayıtlı.');
            redirect('tournaments/view?id=' . $tournamentId);
            return;
        }
        
        // Takımı turnuvaya kaydet
        $result = $database->insert('tournament_teams', [
            'tournament_id' => $tournamentId,
            'team_id' => $teamId,
            'status' => 'pending'
        ]);
        
        if ($result) {
            Session::setFlash('success', 'Takımınız turnuvaya başarıyla kaydedildi. Onay bekliyor.');
        } else {
            Session::setFlash('error', 'Takım kaydı sırasında bir hata oluştu.');
        }
        
        redirect('tournaments/view?id=' . $tournamentId);
    }

}