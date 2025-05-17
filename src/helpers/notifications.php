// src/helpers/Notification.php
<?php
class Notification {
    // Bildirim oluşturma
    public static function create($userId, $title, $message, $link = null) {
        global $database;
        
        return $database->insert('notifications', [
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'link' => $link
        ]);
    }
    
    // Kullanıcının okunmamış bildirimlerini getirme
    public static function getUnread($userId, $limit = 5) {
        global $database;
        
        return $database->fetchAll(
            "SELECT * FROM notifications 
            WHERE user_id = ? AND is_read = 0
            ORDER BY created_at DESC
            LIMIT ?",
            [$userId, $limit]
        );
    }
    
    // Bildirimi okundu olarak işaretleme
    public static function markAsRead($notificationId, $userId) {
        global $database;
        
        return $database->update('notifications', 
            ['is_read' => 1], 
            ['id' => $notificationId, 'user_id' => $userId]
        );
    }
    
    // Tüm bildirimleri okundu olarak işaretleme
    public static function markAllAsRead($userId) {
        global $database;
        
        return $database->update('notifications', 
            ['is_read' => 1], 
            ['user_id' => $userId, 'is_read' => 0]
        );
    }
    
    // Okunmamış bildirim sayısını getir
    public static function countUnread($userId) {
        global $database;
        
        $result = $database->fetch(
            "SELECT COUNT(*) as count FROM notifications 
            WHERE user_id = ? AND is_read = 0",
            [$userId]
        );
        
        return $result ? $result['count'] : 0;
    }
}