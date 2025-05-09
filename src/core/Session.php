<?php
class Session {
    // Oturum değişkeni ayarlama
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }
    
    // Oturum değişkeni alma
    public static function get($key, $default = null) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    // Oturum değişkeni var mı kontrol etme
    public static function has($key) {
        return isset($_SESSION[$key]);
    }
    
    // Oturum değişkeni silme
    public static function delete($key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
    
    // Tüm oturum verilerini temizleme
    public static function clear() {
        session_unset();
        return session_destroy();
    }
    
    // Flash mesajları (bir kez gösterilen)
    public static function setFlash($key, $message) {
        self::set('flash_' . $key, $message);
    }
    
    public static function getFlash($key, $default = null) {
        $flashKey = 'flash_' . $key;
        $value = self::get($flashKey, $default);
        self::delete($flashKey);
        return $value;
    }
    
    public static function hasFlash($key) {
        return self::has('flash_' . $key);
    }
}