<?php
class HomeController {
    // Ana sayfa
    public function index() {
        // Veritabanından veri çekme işlemlerini sonra ekleyeceğiz
        $data = [
            'pageTitle' => 'Ana Sayfa',
            'latestTournaments' => [],
            'latestTeams' => []
        ];
        
        // Görünüm içeriğini al
        ob_start();
        view('home/index', $data);
        $content = ob_get_clean();
        
        // Ana şablona yerleştir
        view('layouts/main', ['content' => $content, 'pageTitle' => $data['pageTitle']]);
    }
    
    // Test sayfası
    public function test() {
        $data = [
            'pageTitle' => 'Test Sayfası',
            'message' => 'Bu bir test sayfasıdır.'
        ];
        
        // Görünüm içeriğini al
        ob_start();
        view('home/test', $data);
        $content = ob_get_clean();
        
        // Ana şablona yerleştir
        view('layouts/main', ['content' => $content, 'pageTitle' => $data['pageTitle']]);
    }
}