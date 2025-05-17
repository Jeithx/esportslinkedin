<?php
class TeamListingController {
    // List all active team listings
    public function index() {
        global $database;
        
        // Get filter parameters (optional)
        $gameId = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 0;
        $position = isset($_GET['position']) ? trim($_GET['position']) : '';
        
        // Base query
        $query = "SELECT tl.*, t.name as team_name, t.logo as team_logo, g.name as game_name, g.slug as game_slug
                 FROM team_listings tl
                 JOIN teams t ON tl.team_id = t.id
                 JOIN games g ON tl.game_id = g.id
                 WHERE tl.status = 'active'";
        $params = [];
        
        // Add filters if provided
        if ($gameId > 0) {
            $query .= " AND tl.game_id = ?";
            $params[] = $gameId;
        }
        
        if (!empty($position)) {
            $query .= " AND tl.position LIKE ?";
            $params[] = "%$position%";
        }
        
        $query .= " ORDER BY tl.created_at DESC";
        
        // Get listings
        $listings = $database->fetchAll($query, $params);
        
        // Get games for filter dropdown
        $games = $database->fetchAll("SELECT * FROM games ORDER BY name ASC");
        
        // Common positions for filter dropdown
        $positions = [
            'League of Legends' => ['Top', 'Jungle', 'Mid', 'ADC', 'Support'],
            'Valorant' => ['Duelist', 'Initiator', 'Controller', 'Sentinel'],
            'CS2' => ['AWPer', 'Rifler', 'Entry Fragger', 'Support', 'IGL'],
            'R6' => ['Fragger', 'Support', 'Flex', 'Hard Breach', 'IGL']
        ];
        
        // View data
        $data = [
            'pageTitle' => 'Takım İlanları',
            'listings' => $listings,
            'games' => $games,
            'positions' => $positions,
            'selectedGame' => $gameId,
            'selectedPosition' => $position,
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('listings/index', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Create new listing form
    public function createForm() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user's teams where they are captain
        $userId = Session::get('user_id');
        $teams = $database->fetchAll(
            "SELECT t.* FROM teams t
             JOIN team_members tm ON t.id = tm.team_id
             WHERE tm.user_id = ? AND tm.role = 'captain'",
            [$userId]
        );
        
        if (empty($teams)) {
            Session::setFlash('error', 'İlan oluşturmak için bir takımın kaptanı olmalısınız.');
            redirect('/teams');
            return;
        }
        
        // Get games
        $games = $database->fetchAll("SELECT * FROM games ORDER BY name ASC");
        
        // Common positions by game
        $positions = [
            'League of Legends' => ['Top', 'Jungle', 'Mid', 'ADC', 'Support'],
            'Valorant' => ['Duelist', 'Initiator', 'Controller', 'Sentinel'],
            'CS2' => ['AWPer', 'Rifler', 'Entry Fragger', 'Support', 'IGL'],
            'R6' => ['Fragger', 'Support', 'Flex', 'Hard Breach', 'IGL']
        ];
        
        // View data
        $data = [
            'pageTitle' => 'Yeni İlan Oluştur',
            'teams' => $teams,
            'games' => $games,
            'positions' => json_encode($positions),
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('listings/create', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Create new listing (POST)
    public function create() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get POST data
        $teamId = isset($_POST['team_id']) ? (int)$_POST['team_id'] : 0;
        $gameId = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $requirements = isset($_POST['requirements']) ? trim($_POST['requirements']) : '';
        $position = isset($_POST['position']) ? trim($_POST['position']) : '';
        
        // Validation
        $validation = new Validation($_POST);
        $validation->required('team_id', 'Takım seçimi gereklidir.')
                   ->required('game_id', 'Oyun seçimi gereklidir.')
                   ->required('title', 'İlan başlığı gereklidir.')
                   ->minLength('title', 5, 'İlan başlığı en az 5 karakter olmalıdır.')
                   ->maxLength('title', 100, 'İlan başlığı en fazla 100 karakter olabilir.')
                   ->required('description', 'İlan açıklaması gereklidir.')
                   ->required('position', 'Pozisyon bilgisi gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/teams/listings/create');
            return;
        }
        
        // Verify user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
             WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$teamId, $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları ilan oluşturabilir.');
            redirect('/teams/listings/create');
            return;
        }
        
        // Insert the listing
        $listingId = $database->insert('team_listings', [
            'team_id' => $teamId,
            'game_id' => $gameId,
            'title' => $title,
            'description' => $description,
            'requirements' => $requirements,
            'position' => $position,
            'status' => 'active'
        ]);
        
        if ($listingId) {
            Session::setFlash('success', 'İlan başarıyla oluşturuldu.');
            redirect('/teams/listings/view?id=' . $listingId);
        } else {
            Session::setFlash('error', 'İlan oluşturulurken bir hata oluştu.');
            redirect('/teams/listings/create');
        }
    }
    
    // View listing details
    public function view() {
        global $database;
        
        // Get listing ID
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            Session::setFlash('error', 'Geçersiz ilan ID\'si.');
            redirect('/teams/listings');
            return;
        }
        
        // Get listing details
        $listing = $database->fetch(
            "SELECT tl.*, t.name as team_name, t.logo as team_logo, t.id as team_id,
                    g.name as game_name, g.slug as game_slug
             FROM team_listings tl
             JOIN teams t ON tl.team_id = t.id
             JOIN games g ON tl.game_id = g.id
             WHERE tl.id = ?",
            [$id]
        );
        
        if (!$listing) {
            Session::setFlash('error', 'İlan bulunamadı.');
            redirect('/teams/listings');
            return;
        }
        
        // Get team members
        $teamMembers = $database->fetchAll(
            "SELECT u.*, tm.role as team_role
             FROM users u
             JOIN team_members tm ON u.id = tm.user_id
             WHERE tm.team_id = ?
             ORDER BY tm.role DESC, u.username ASC",
            [$listing['team_id']]
        );
        
        // Check if the user has already applied
        $hasApplied = false;
        if (Auth::isLoggedIn()) {
            $userId = Session::get('user_id');
            $application = $database->fetch(
                "SELECT * FROM listing_applications 
                 WHERE listing_id = ? AND user_id = ?",
                [$id, $userId]
            );
            
            $hasApplied = !empty($application);
            
            // Check if user is already a member of the team
            $isMember = $database->fetch(
                "SELECT * FROM team_members 
                 WHERE team_id = ? AND user_id = ?",
                [$listing['team_id'], $userId]
            );
            
            // Check if user is the team captain
            $isCaptain = $isMember && $isMember['role'] === 'captain';
            
            // Check if user has required profile for the game
            $hasGameProfile = $database->fetch(
                "SELECT * FROM user_game_profiles 
                 WHERE user_id = ? AND game_id = ?",
                [$userId, $listing['game_id']]
            );
        } else {
            $isMember = false;
            $isCaptain = false;
            $hasGameProfile = false;
        }
        
        // If user is captain, get applications
        $applications = [];
        if (isset($isCaptain) && $isCaptain) {
            $applications = $database->fetchAll(
                "SELECT la.*, u.username, u.avatar, u.full_name, ugp.rank, ugp.main_position
                 FROM listing_applications la
                 JOIN users u ON la.user_id = u.id
                 LEFT JOIN user_game_profiles ugp ON u.id = ugp.user_id AND ugp.game_id = ?
                 WHERE la.listing_id = ?
                 ORDER BY la.created_at DESC",
                [$listing['game_id'], $id]
            );
        }
        
        // View data
        $data = [
            'pageTitle' => $listing['title'],
            'listing' => $listing,
            'teamMembers' => $teamMembers,
            'hasApplied' => $hasApplied,
            'isMember' => $isMember,
            'isCaptain' => $isCaptain ?? false,
            'hasGameProfile' => $hasGameProfile,
            'applications' => $applications,
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('listings/view', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Edit listing form
    public function editForm() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get listing ID
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if (!$id) {
            Session::setFlash('error', 'Geçersiz ilan ID\'si.');
            redirect('/teams/listings');
            return;
        }
        
        // Get listing details
        $listing = $database->fetch(
            "SELECT * FROM team_listings WHERE id = ?",
            [$id]
        );
        
        if (!$listing) {
            Session::setFlash('error', 'İlan bulunamadı.');
            redirect('/teams/listings');
            return;
        }
        
        // Verify user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
             WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$listing['team_id'], $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları ilanları düzenleyebilir.');
            redirect('/teams/listings/view?id=' . $id);
            return;
        }
        
        // Get team info
        $team = $database->fetch(
            "SELECT * FROM teams WHERE id = ?",
            [$listing['team_id']]
        );
        
        // Get games
        $games = $database->fetchAll("SELECT * FROM games ORDER BY name ASC");
        
        // Common positions by game
        $positions = [
            'League of Legends' => ['Top', 'Jungle', 'Mid', 'ADC', 'Support'],
            'Valorant' => ['Duelist', 'Initiator', 'Controller', 'Sentinel'],
            'CS2' => ['AWPer', 'Rifler', 'Entry Fragger', 'Support', 'IGL'],
            'R6' => ['Fragger', 'Support', 'Flex', 'Hard Breach', 'IGL']
        ];
        
        // View data
        $data = [
            'pageTitle' => 'İlanı Düzenle',
            'listing' => $listing,
            'team' => $team,
            'games' => $games,
            'positions' => json_encode($positions),
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('listings/edit', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Update listing (POST)
    public function update() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get POST data
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $gameId = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        $title = isset($_POST['title']) ? trim($_POST['title']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $requirements = isset($_POST['requirements']) ? trim($_POST['requirements']) : '';
        $position = isset($_POST['position']) ? trim($_POST['position']) : '';
        $status = isset($_POST['status']) ? trim($_POST['status']) : 'active';
        
        // Get the current listing
        $listing = $database->fetch(
            "SELECT * FROM team_listings WHERE id = ?",
            [$id]
        );
        
        if (!$listing) {
            Session::setFlash('error', 'İlan bulunamadı.');
            redirect('/teams/listings');
            return;
        }
        
        // Verify user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
             WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$listing['team_id'], $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları ilanları düzenleyebilir.');
            redirect('/teams/listings/view?id=' . $id);
            return;
        }
        
        // Validation
        $validation = new Validation($_POST);
        $validation->required('game_id', 'Oyun seçimi gereklidir.')
                   ->required('title', 'İlan başlığı gereklidir.')
                   ->minLength('title', 5, 'İlan başlığı en az 5 karakter olmalıdır.')
                   ->maxLength('title', 100, 'İlan başlığı en fazla 100 karakter olabilir.')
                   ->required('description', 'İlan açıklaması gereklidir.')
                   ->required('position', 'Pozisyon bilgisi gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/teams/listings/edit?id=' . $id);
            return;
        }
        
        // Only allow specific status values
        if (!in_array($status, ['active', 'filled', 'closed'])) {
            $status = 'active';
        }
        
        // Update the listing
        $result = $database->update('team_listings', [
            'game_id' => $gameId,
            'title' => $title,
            'description' => $description,
            'requirements' => $requirements,
            'position' => $position,
            'status' => $status
        ], ['id' => $id]);
        
        if ($result) {
            Session::setFlash('success', 'İlan başarıyla güncellendi.');
            redirect('/teams/listings/view?id=' . $id);
        } else {
            Session::setFlash('error', 'İlan güncellenirken bir hata oluştu.');
            redirect('/teams/listings/edit?id=' . $id);
        }
    }
    
    // Delete listing (POST)
    public function delete() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get listing ID
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        
        if (!$id) {
            Session::setFlash('error', 'Geçersiz ilan ID\'si.');
            redirect('/teams/listings');
            return;
        }
        
        // Get the listing
        $listing = $database->fetch(
            "SELECT * FROM team_listings WHERE id = ?",
            [$id]
        );
        
        if (!$listing) {
            Session::setFlash('error', 'İlan bulunamadı.');
            redirect('/teams/listings');
            return;
        }
        
        // Verify user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
             WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$listing['team_id'], $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları ilanları silebilir.');
            redirect('/teams/listings/view?id=' . $id);
            return;
        }
        
        // Delete the listing
        $result = $database->delete('team_listings', ['id' => $id]);
        
        if ($result) {
            Session::setFlash('success', 'İlan başarıyla silindi.');
            redirect('/teams/listings');
        } else {
            Session::setFlash('error', 'İlan silinirken bir hata oluştu.');
            redirect('/teams/listings/view?id=' . $id);
        }
    }
    
    // View my team's listings
    public function myListings() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user's teams where they are captain
        $userId = Session::get('user_id');
        $teams = $database->fetchAll(
            "SELECT t.id, t.name FROM teams t
             JOIN team_members tm ON t.id = tm.team_id
             WHERE tm.user_id = ? AND tm.role = 'captain'",
            [$userId]
        );
        
        $teamIds = array_column($teams, 'id');
        
        // If user is not a captain of any team
        if (empty($teamIds)) {
            Session::setFlash('info', 'Şu anda bir takımın kaptanı değilsiniz. Takım kaptanları ilan yönetimi yapabilir.');
            redirect('/teams/listings');
            return;
        }
        
        // Format for SQL IN clause
        $placeholders = implode(',', array_fill(0, count($teamIds), '?'));
        
        // Get listings for user's teams
        $listings = $database->fetchAll(
            "SELECT tl.*, t.name as team_name, t.logo as team_logo, g.name as game_name, g.slug as game_slug,
                    (SELECT COUNT(*) FROM listing_applications WHERE listing_id = tl.id AND status = 'pending') as pending_applications
             FROM team_listings tl
             JOIN teams t ON tl.team_id = t.id
             JOIN games g ON tl.game_id = g.id
             WHERE tl.team_id IN ($placeholders)
             ORDER BY tl.created_at DESC",
            $teamIds
        );
        
        // View data
        $data = [
            'pageTitle' => 'İlanlarım',
            'listings' => $listings,
            'teams' => $teams,
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('listings/my_listings', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
}