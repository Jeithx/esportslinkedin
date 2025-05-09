<?php
class Router {
    protected $routes = [];
    protected $currentRoute = null;
    
    // Rota ekleme
    public function add($route, $controller, $action, $method = 'GET') {
        $this->routes[] = [
            'route' => $route,
            'controller' => $controller,
            'action' => $action,
            'method' => $method
        ];
    }
    
    // İsteği uygun yönlendirmeye gönderme
    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        // URL'deki sorgu dizesini kaldır
        if (($pos = strpos($uri, '?')) !== false) {
            $uri = substr($uri, 0, $pos);
        }
        
        // Yerel geliştirme için klasör yapısını kontrol et
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Son eğik çizgiyi kaldır
        $uri = rtrim($uri, '/');
        if (empty($uri)) {
            $uri = '/';
        }
        
        // Uygun rotayı bul
        foreach ($this->routes as $route) {
            if ($route['route'] === $uri && $route['method'] === $method) {
                $this->currentRoute = $route;
                $this->runAction($route['controller'], $route['action']);
                return;
            }
        }
        
        // Eşleşen rota bulunamadı
        $this->notFound();
    }
    
    // Kontrolcü ve aksiyonu çalıştırma
    protected function runAction($controller, $action) {
        // Kontrolcü sınıfının nesnesi zaten oluşturulmuş mu kontrol et
        $controllerInstance = null;
        
        // Kontrolcü sınıfı zaten dahil edilmiş mi kontrol et
        if (class_exists($controller)) {
            $controllerInstance = new $controller();
        } else {
            // Kontrolcü dosyasını dahil et
            $controllerFile = CONTROLLER_PATH . "/{$controller}.php";
            
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerInstance = new $controller();
            } else {
                die("Hata: Kontrolcü dosyası bulunamadı: {$controllerFile}");
            }
        }
        
        // Kontrolcü metodu var mı kontrol et
        if ($controllerInstance && method_exists($controllerInstance, $action)) {
            $controllerInstance->$action();
        } else {
            die("Hata: Kontrolcü metodu bulunamadı: {$controller}::{$action}");
        }
    }
    
    // 404 Sayfası
    protected function notFound($message = 'Sayfa bulunamadı.') {
        header('HTTP/1.1 404 Not Found');
        
        // Hata sayfasını göster
        if (file_exists(VIEW_PATH . '/errors/404.php')) {
            require_once VIEW_PATH . '/errors/404.php';
        } else {
            echo "<h1>404</h1>";
            echo "<p>Sayfa Bulunamadı</p>";
            echo "<p>Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>";
        }
        
        exit;
    }
}