<?php
class PlayerController {
    // Show player game profile
    public function profile() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user ID from session
        $userId = Session::get('user_id');
        
        // Get user info
        $user = $database->fetch(
            "SELECT * FROM users WHERE id = ?",
            [$userId]
        );
        
        if (!$user) {
            Session::setFlash('error', 'Kullanıcı bulunamadı.');
            redirect('/');
            return;
        }
        
        // Get player's game profiles
        $gameProfiles = $database->fetchAll(
            "SELECT ugp.*, g.name as game_name, g.slug as game_slug
             FROM user_game_profiles ugp
             JOIN games g ON ugp.game_id = g.id
             WHERE ugp.user_id = ?
             ORDER BY g.name ASC",
            [$userId]
        );
        
        // Get all games for creating new profiles
        $allGames = $database->fetchAll("SELECT * FROM games ORDER BY name ASC");
        
        // Filter out games that already have profiles
        $profileGameIds = array_column($gameProfiles, 'game_id');
        $availableGames = array_filter($allGames, function($game) use ($profileGameIds) {
            return !in_array($game['id'], $profileGameIds);
        });
        
        // View data
        $data = [
            'pageTitle' => 'Oyuncu Profilim',
            'user' => $user,
            'gameProfiles' => $gameProfiles,
            'availableGames' => $availableGames
        ];
        
        // Show view
        ob_start();
        view('player/profile', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Show game profile creation form
    public function createProfileForm() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user ID from session
        $userId = Session::get('user_id');
        
        // Get game ID from GET parameter
        $gameId = isset($_GET['game_id']) ? (int)$_GET['game_id'] : 0;
        
        if (!$gameId) {
            Session::setFlash('error', 'Oyun seçimi gereklidir.');
            redirect('/player/profile');
            return;
        }
        
        // Check if profile already exists
        $existingProfile = $database->fetch(
            "SELECT * FROM user_game_profiles 
             WHERE user_id = ? AND game_id = ?",
            [$userId, $gameId]
        );
        
        if ($existingProfile) {
            Session::setFlash('info', 'Bu oyun için zaten bir profiliniz bulunmaktadır.');
            redirect('/player/profile');
            return;
        }
        
        // Get game info
        $game = $database->fetch(
            "SELECT * FROM games WHERE id = ?",
            [$gameId]
        );
        
        if (!$game) {
            Session::setFlash('error', 'Oyun bulunamadı.');
            redirect('/player/profile');
            return;
        }
        
        // Game specific positions and ranks
        $gamePositions = [
            'lol' => [
                'positions' => ['Top', 'Jungle', 'Mid', 'ADC', 'Support'],
                'ranks' => ['Iron', 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Master', 'Grandmaster', 'Challenger']
            ],
            'valorant' => [
                'positions' => ['Duelist', 'Initiator', 'Controller', 'Sentinel'],
                'ranks' => ['Iron', 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Ascendant', 'Immortal', 'Radiant']
            ],
            'cs2' => [
                'positions' => ['AWPer', 'Rifler', 'Entry Fragger', 'Support', 'IGL'],
                'ranks' => ['Silver I', 'Silver II', 'Silver III', 'Silver IV', 'Silver Elite', 'Silver Elite Master', 
                           'Gold Nova I', 'Gold Nova II', 'Gold Nova III', 'Gold Nova Master', 
                           'Master Guardian I', 'Master Guardian II', 'Master Guardian Elite', 'Distinguished Master Guardian',
                           'Legendary Eagle', 'Legendary Eagle Master', 'Supreme Master First Class', 'Global Elite']
            ],
            'r6' => [
                'positions' => ['Fragger', 'Support', 'Flex', 'Hard Breach', 'IGL'],
                'ranks' => ['Copper', 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Champion']
            ]
        ];
        
        $positions = $gamePositions[$game['slug']]['positions'] ?? [];
        $ranks = $gamePositions[$game['slug']]['ranks'] ?? [];
        
        // View data
        $data = [
            'pageTitle' => $game['name'] . ' Profili Oluştur',
            'game' => $game,
            'positions' => $positions,
            'ranks' => $ranks
        ];
        
        // Show view
        ob_start();
        view('player/create_profile', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Create game profile (POST)
    public function createProfile() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user ID from session
        $userId = Session::get('user_id');
        
        // Get POST data
        $gameId = isset($_POST['game_id']) ? (int)$_POST['game_id'] : 0;
        $rank = isset($_POST['rank']) ? trim($_POST['rank']) : '';
        $mainPosition = isset($_POST['main_position']) ? trim($_POST['main_position']) : '';
        $secondaryPosition = isset($_POST['secondary_position']) ? trim($_POST['secondary_position']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $lookingForTeam = isset($_POST['looking_for_team']) ? 1 : 0;
        
        // Validation
        $validation = new Validation($_POST);
        $validation->required('game_id', 'Oyun seçimi gereklidir.')
                   ->required('main_position', 'Ana pozisyon seçimi gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/player/profile/create?game_id=' . $gameId);
            return;
        }
        
        // Check if profile already exists
        $existingProfile = $database->fetch(
            "SELECT * FROM user_game_profiles 
             WHERE user_id = ? AND game_id = ?",
            [$userId, $gameId]
        );
        
        if ($existingProfile) {
            Session::setFlash('info', 'Bu oyun için zaten bir profiliniz bulunmaktadır.');
            redirect('/player/profile');
            return;
        }
        
        // Create profile
        $profileId = $database->insert('user_game_profiles', [
            'user_id' => $userId,
            'game_id' => $gameId,
            'rank' => $rank,
            'main_position' => $mainPosition,
            'secondary_position' => $secondaryPosition,
            'description' => $description,
            'looking_for_team' => $lookingForTeam
        ]);
        
        if ($profileId) {
            Session::setFlash('success', 'Oyuncu profili başarıyla oluşturuldu.');
            redirect('/player/profile');
        } else {
            Session::setFlash('error', 'Profil oluşturulurken bir hata oluştu.');
            redirect('/player/profile/create?game_id=' . $gameId);
        }
    }
    
    // Update game profile (POST)
    public function updateProfile() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user ID from session
        $userId = Session::get('user_id');
        
        // Get POST data
        $profileId = isset($_POST['profile_id']) ? (int)$_POST['profile_id'] : 0;
        $rank = isset($_POST['rank']) ? trim($_POST['rank']) : '';
        $mainPosition = isset($_POST['main_position']) ? trim($_POST['main_position']) : '';
        $secondaryPosition = isset($_POST['secondary_position']) ? trim($_POST['secondary_position']) : '';
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $lookingForTeam = isset($_POST['looking_for_team']) ? 1 : 0;
        
        // Validation
        $validation = new Validation($_POST);
        $validation->required('profile_id', 'Profil ID gereklidir.')
                   ->required('main_position', 'Ana pozisyon seçimi gereklidir.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/player/profile');
            return;
        }
        
        // Check if profile exists and belongs to user
        $profile = $database->fetch(
            "SELECT * FROM user_game_profiles 
             WHERE id = ? AND user_id = ?",
            [$profileId, $userId]
        );
        
        if (!$profile) {
            Session::setFlash('error', 'Profil bulunamadı veya size ait değil.');
            redirect('/player/profile');
            return;
        }
        
        // Update profile
        $result = $database->update('user_game_profiles', [
            'rank' => $rank,
            'main_position' => $mainPosition,
            'secondary_position' => $secondaryPosition,
            'description' => $description,
            'looking_for_team' => $lookingForTeam
        ], ['id' => $profileId]);
        
        if ($result) {
            Session::setFlash('success', 'Oyuncu profili başarıyla güncellendi.');
        } else {
            Session::setFlash('error', 'Profil güncellenirken bir hata oluştu.');
        }
        
        redirect('/player/profile');
    }
}