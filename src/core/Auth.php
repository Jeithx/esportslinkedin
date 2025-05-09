<?php
class Auth {
    // Kullanıcı girişi yapma
    public static function login($user) {
        Session::set('user_id', $user['id']);
        Session::set('user_name', $user['username']);
        Session::set('user_email', $user['email']);
        Session::set('user_role', $user['role']);
        Session::set('is_logged_in', true);
    }
    
    // Kullanıcı çıkışı yapma
    public static function logout() {
        Session::delete('user_id');
        Session::delete('user_name');
        Session::delete('user_email');
        Session::delete('user_role');
        Session::delete('is_logged_in');
        
        // Oturumu tamamen temizle
        Session::clear();
    }
    
    // Kullanıcı giriş yapmış mı kontrol et
    public static function isLoggedIn() {
        return Session::has('is_logged_in') && Session::get('is_logged_in') === true;
    }
    
    // Şifreyi hashleme
    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    }
    
    // Şifre doğrulama
    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    // Kullanıcının rolünü kontrol et
    public static function hasRole($role) {
        if (!self::isLoggedIn()) {
            return false;
        }
        
        return Session::get('user_role') === $role;
    }
    
    // Admin mi kontrol et
    public static function isAdmin() {
        return self::hasRole('admin');
    }
    
    // Giriş gerektiren sayfalara erişimi kontrol et
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            Session::setFlash('error', 'Bu sayfaya erişmek için giriş yapmalısınız.');
            header('Location: ' . SITE_URL . '/login');
            exit;
        }
    }
    
    // Admin erişimi gerektiren sayfalara erişimi kontrol et
    public static function requireAdmin() {
        self::requireLogin();
        
        if (!self::isAdmin()) {
            Session::setFlash('error', 'Bu sayfaya erişim izniniz yok.');
            header('Location: ' . SITE_URL);
            exit;
        }
    }
}