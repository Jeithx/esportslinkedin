<?php
class HomeController {
    // Ana sayfa
    public function index() {
        global $database;
        
        // Aktif ve kayıt açık turnuvaları getir (en son 3 adet)
        $latestTournaments = $database->fetchAll(
            "SELECT t.*, g.name as game_name, g.slug as game_slug
            FROM tournaments t
            JOIN games g ON t.game_id = g.id
            WHERE t.status IN ('registration', 'active') 
            ORDER BY t.start_date ASC
            LIMIT 3"
        );
        
        // Popüler takımları getir (en son oluşturulan 3 adet)
        $latestTeams = $database->fetchAll(
            "SELECT t.*, 
                (SELECT COUNT(*) FROM team_members WHERE team_id = t.id) as member_count
            FROM teams t
            ORDER BY t.created_at DESC
            LIMIT 3"
        );
        
        $data = [
            'pageTitle' => 'Ana Sayfa',
            'latestTournaments' => $latestTournaments,
            'latestTeams' => $latestTeams
        ];
        
        // Görünüm içeriğini al
        ob_start();
        view('home/index', $data);
        $content = ob_get_clean();
        
        // Ana şablona yerleştir
        view('layouts/main', ['content' => $content, 'pageTitle' => $data['pageTitle']]);
    }
}