<?php
// URL oluşturma
function url($path = '') {
    $path = ltrim($path, '/');
    return SITE_URL . '/' . $path;
}

// Görünüm dosyasını dahil etme
function view($view, $data = []) {
    // Değişkenleri ayıkla
    extract($data);
    
    // Görünüm dosyasını dahil et
    $viewFile = VIEW_PATH . '/' . $view . '.php';
    
    if (file_exists($viewFile)) {
        require $viewFile;
    } else {
        die("Görünüm dosyası bulunamadı: {$view}");
    }
}

// Yönlendirme
function redirect($url) {
    header('Location: ' . url($url));
    exit;
}

// XSS koruması için HTML özel karakterlerini dönüştürme
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// CSRF token oluşturma
function csrf_token() {
    if (!Session::has('csrf_token')) {
        $token = bin2hex(random_bytes(32));
        Session::set('csrf_token', $token);
    }
    
    return Session::get('csrf_token');
}

// CSRF token doğrulama
function verify_csrf_token($token) {
    return $token === Session::get('csrf_token');
}

// Flash mesajlarını gösterme
function flash_messages() {
    $types = ['success', 'error', 'warning', 'info'];
    $html = '';
    
    foreach ($types as $type) {
        if (Session::hasFlash($type)) {
            $message = Session::getFlash($type);
            // X butonu kaldırıldı
            $html .= "<div class='alert alert-{$type}'>{$message}</div>";
        }
    }
    
    return $html;
}

// Para birimini formatla
function format_money($amount, $currency = '₺') {
    return $currency . ' ' . number_format($amount, 2, ',', '.');
}

// Tarihi formatla
function format_date($date, $format = 'd.m.Y H:i') {
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

// Zaman farkını insanların anlayabileceği şekilde formatla
function time_ago($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return $diff . ' saniye önce';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' dakika önce';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' saat önce';
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . ' gün önce';
    } elseif ($diff < 2592000) {
        return floor($diff / 604800) . ' hafta önce';
    } elseif ($diff < 31536000) {
        return floor($diff / 2592000) . ' ay önce';
    } else {
        return floor($diff / 31536000) . ' yıl önce';
    }
}