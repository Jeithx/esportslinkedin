// src/controllers/NotificationController.php
<?php
class NotificationController {
    // Bildirimi okundu olarak işaretle
    public function markAsRead() {
        // Kullanıcı girişi kontrolü
        Auth::requireLogin();
        
        // POST verilerini al
        $notificationId = isset($_POST['notification_id']) ? (int)$_POST['notification_id'] : 0;
        
        if (!$notificationId) {
            echo json_encode(['success' => false, 'message' => 'Geçersiz bildirim ID\'si.']);
            return;
        }
        
        // Bildirimi okundu olarak işaretle
        $userId = Session::get('user_id');
        $result = Notification::markAsRead($notificationId, $userId);
        
        echo json_encode(['success' => $result]);
    }
    
    // Tüm bildirimleri okundu olarak işaretle
    public function markAllAsRead() {
        // Kullanıcı girişi kontrolü
        Auth::requireLogin();
        
        // Tüm bildirimleri okundu olarak işaretle
        $userId = Session::get('user_id');
        $result = Notification::markAllAsRead($userId);
        
        echo json_encode(['success' => $result]);
    }
    
    // Okunmamış bildirim sayısını getir
    public function count() {
        // Kullanıcı girişi kontrolü
        Auth::requireLogin();
        
        // Okunmamış bildirim sayısını getir
        $userId = Session::get('user_id');
        $count = Notification::countUnread($userId);
        
        echo json_encode(['count' => $count]);
    }
}