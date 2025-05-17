<?php
class ApplicationController {
    // Apply to a listing
    public function apply() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user ID from session
        $userId = Session::get('user_id');
        
        // Get POST data
        $listingId = isset($_POST['listing_id']) ? (int)$_POST['listing_id'] : 0;
        $message = isset($_POST['message']) ? trim($_POST['message']) : '';
        
        // Validation
        $validation = new Validation($_POST);
        $validation->required('listing_id', 'İlan ID gereklidir.')
                  ->required('message', 'Başvuru mesajı gereklidir.')
                  ->minLength('message', 10, 'Başvuru mesajı en az 10 karakter olmalıdır.');
        
        if ($validation->fails()) {
            Session::setFlash('error', $validation->getFirstError());
            redirect('/teams/listings/view?id=' . $listingId);
            return;
        }
        
        // Get listing details
        $listing = $database->fetch(
            "SELECT * FROM team_listings WHERE id = ?",
            [$listingId]
        );
        
        if (!$listing) {
            Session::setFlash('error', 'İlan bulunamadı.');
            redirect('/teams/listings');
            return;
        }
        
        // Check if listing is active
        if ($listing['status'] !== 'active') {
            Session::setFlash('error', 'Bu ilan artık aktif değil.');
            redirect('/teams/listings/view?id=' . $listingId);
            return;
        }
        
        // Check if user is already a member of the team
        $isMember = $database->fetch(
            "SELECT * FROM team_members 
             WHERE team_id = ? AND user_id = ?",
            [$listing['team_id'], $userId]
        );
        
        if ($isMember) {
            Session::setFlash('error', 'Zaten bu takımın üyesisiniz.');
            redirect('/teams/listings/view?id=' . $listingId);
            return;
        }
        
        // Check if user has already applied
        $existingApplication = $database->fetch(
            "SELECT * FROM listing_applications 
             WHERE listing_id = ? AND user_id = ?",
            [$listingId, $userId]
        );
        
        if ($existingApplication) {
            Session::setFlash('error', 'Bu ilana zaten başvurdunuz.');
            redirect('/teams/listings/view?id=' . $listingId);
            return;
        }
        
        // Create application
        $applicationId = $database->insert('listing_applications', [
            'listing_id' => $listingId,
            'user_id' => $userId,
            'message' => $message,
            'status' => 'pending'
        ]);
        
        if ($applicationId) {
            Session::setFlash('success', 'Başvurunuz başarıyla gönderildi.');
        } else {
            Session::setFlash('error', 'Başvuru gönderilirken bir hata oluştu.');
        }
        
        redirect('/teams/listings/view?id=' . $listingId);
    }
    
    // View my applications
    public function myApplications() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get user ID from session
        $userId = Session::get('user_id');
        
        // Get user's applications
        $applications = $database->fetchAll(
            "SELECT la.*, tl.title as listing_title, tl.position,
                    t.name as team_name, t.logo as team_logo,
                    g.name as game_name, g.slug as game_slug
             FROM listing_applications la
             JOIN team_listings tl ON la.listing_id = tl.id
             JOIN teams t ON tl.team_id = t.id
             JOIN games g ON tl.game_id = g.id
             WHERE la.user_id = ?
             ORDER BY la.created_at DESC",
            [$userId]
        );
        
        // View data
        $data = [
            'pageTitle' => 'Başvurularım',
            'applications' => $applications,
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('applications/my_applications', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // View applications for a team
    public function teamApplications() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get team ID from GET parameter
        $teamId = isset($_GET['team_id']) ? (int)$_GET['team_id'] : 0;
        
        if (!$teamId) {
            Session::setFlash('error', 'Takım ID gereklidir.');
            redirect('/teams');
            return;
        }
        
        // Check if user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
             WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$teamId, $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları başvuruları görüntüleyebilir.');
            redirect('/teams/view?id=' . $teamId);
            return;
        }
        
        // Get team info
        $team = $database->fetch(
            "SELECT * FROM teams WHERE id = ?",
            [$teamId]
        );
        
        if (!$team) {
            Session::setFlash('error', 'Takım bulunamadı.');
            redirect('/teams');
            return;
        }
        
        // Get applications for this team
        $applications = $database->fetchAll(
            "SELECT la.*, tl.title as listing_title, tl.position, tl.status as listing_status,
                    u.username, u.avatar, u.full_name,
                    g.name as game_name, g.slug as game_slug,
                    ugp.rank, ugp.main_position, ugp.secondary_position
             FROM listing_applications la
             JOIN team_listings tl ON la.listing_id = tl.id
             JOIN users u ON la.user_id = u.id
             JOIN games g ON tl.game_id = g.id
             LEFT JOIN user_game_profiles ugp ON u.id = ugp.user_id AND ugp.game_id = tl.game_id
             WHERE tl.team_id = ?
             ORDER BY la.created_at DESC",
            [$teamId]
        );
        
        // View data
        $data = [
            'pageTitle' => $team['name'] . ' - Takım Başvuruları',
            'team' => $team,
            'applications' => $applications,
            'cssFiles' => ['listings.css']
        ];
        
        // Show view
        ob_start();
        view('applications/team_applications', $data);
        $content = ob_get_clean();
        
        view('layouts/main', ['content' => $content]);
    }
    
    // Accept an application
    public function accept() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get application ID
        $applicationId = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;
        
        if (!$applicationId) {
            Session::setFlash('error', 'Geçersiz başvuru ID\'si.');
            redirect('/teams');
            return;
        }
        
        // Get application details
        $application = $database->fetch(
            "SELECT la.*, tl.team_id 
            FROM listing_applications la
            JOIN team_listings tl ON la.listing_id = tl.id
            WHERE la.id = ?",
            [$applicationId]
        );
        
        if (!$application) {
            Session::setFlash('error', 'Başvuru bulunamadı.');
            redirect('/teams');
            return;
        }
        
        // Get team details for notification
        $team = $database->fetch(
            "SELECT * FROM teams WHERE id = ?",
            [$application['team_id']]
        );
        
        // Check if user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
            WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$application['team_id'], $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları başvuruları kabul edebilir.');
            redirect('/teams/view?id=' . $application['team_id']);
            return;
        }
        
        // Start transaction
        $database->beginTransaction();
        
        try {
            // Update application status
            $database->update('listing_applications', 
                ['status' => 'accepted'], 
                ['id' => $applicationId]
            );
            
            // Add user to team
            $database->insert('team_members', [
                'team_id' => $application['team_id'],
                'user_id' => $application['user_id'],
                'role' => 'member'
            ]);
            
            // Check if the listing should be marked as filled
            $markAsFilled = isset($_POST['mark_as_filled']) && $_POST['mark_as_filled'] === 'yes';
            
            if ($markAsFilled) {
                $database->update('team_listings', 
                    ['status' => 'filled'], 
                    ['id' => $application['listing_id']]
                );
            }
            
            // Başvuru kabul edildi, bildirim gönder
            Notification::create(
                $application['user_id'],
                'Başvurunuz Kabul Edildi',
                $team['name'] . ' takımına yaptığınız başvuru kabul edildi. Takıma hoş geldiniz!',
                '/teams/view?id=' . $application['team_id']
            );
            
            // Commit transaction
            $database->commit();
            
            Session::setFlash('success', 'Başvuru kabul edildi ve oyuncu takıma eklendi.');
        } catch (Exception $e) {
            // Rollback on error
            $database->rollback();
            Session::setFlash('error', 'İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
        
        redirect('/applications/team-applications?team_id=' . $application['team_id']);
    }
    
    public function reject() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get application ID
        $applicationId = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;
        
        if (!$applicationId) {
            Session::setFlash('error', 'Geçersiz başvuru ID\'si.');
            redirect('/teams');
            return;
        }
        
        // Get application details
        $application = $database->fetch(
            "SELECT la.*, tl.team_id 
            FROM listing_applications la
            JOIN team_listings tl ON la.listing_id = tl.id
            WHERE la.id = ?",
            [$applicationId]
        );
        
        if (!$application) {
            Session::setFlash('error', 'Başvuru bulunamadı.');
            redirect('/teams');
            return;
        }
        
        // Get team details for notification
        $team = $database->fetch(
            "SELECT * FROM teams WHERE id = ?",
            [$application['team_id']]
        );
        
        // Check if user is the team captain
        $userId = Session::get('user_id');
        $isCaptain = $database->fetch(
            "SELECT * FROM team_members 
            WHERE team_id = ? AND user_id = ? AND role = 'captain'",
            [$application['team_id'], $userId]
        );
        
        if (!$isCaptain) {
            Session::setFlash('error', 'Sadece takım kaptanları başvuruları reddedebilir.');
            redirect('/teams/view?id=' . $application['team_id']);
            return;
        }
        
        // Update application status
        $result = $database->update('listing_applications', 
            ['status' => 'rejected'], 
            ['id' => $applicationId]
        );
        
        if ($result) {
            // Başvuru reddedildi, bildirim gönder
            Notification::create(
                $application['user_id'],
                'Başvurunuz Reddedildi',
                $team['name'] . ' takımına yaptığınız başvuru reddedildi.',
                '/applications/my-applications'
            );
            
            Session::setFlash('success', 'Başvuru reddedildi.');
        } else {
            Session::setFlash('error', 'Başvuru reddedilirken bir hata oluştu.');
        }
        
        redirect('/applications/team-applications?team_id=' . $application['team_id']);
    }
    
    // Withdraw an application
    public function withdraw() {
        global $database;
        
        // User must be logged in
        Auth::requireLogin();
        
        // Get application ID
        $applicationId = isset($_POST['application_id']) ? (int)$_POST['application_id'] : 0;
        
        if (!$applicationId) {
            Session::setFlash('error', 'Geçersiz başvuru ID\'si.');
            redirect('/applications/my-applications');
            return;
        }
        
        // Get application details
        $application = $database->fetch(
            "SELECT * FROM listing_applications WHERE id = ?",
            [$applicationId]
        );
        
        if (!$application) {
            Session::setFlash('error', 'Başvuru bulunamadı.');
            redirect('/applications/my-applications');
            return;
        }
        
        // Check if the application belongs to the user
        $userId = Session::get('user_id');
        if ($application['user_id'] !== $userId) {
            Session::setFlash('error', 'Bu başvuruyu geri çekme yetkiniz yok.');
            redirect('/applications/my-applications');
            return;
        }
        
        // Check if application is still pending
        if ($application['status'] !== 'pending') {
            Session::setFlash('error', 'Sadece bekleyen başvurular geri çekilebilir.');
            redirect('/applications/my-applications');
            return;
        }
        
        // Delete the application
        $result = $database->delete('listing_applications', ['id' => $applicationId]);
        
        if ($result) {
            Session::setFlash('success', 'Başvurunuz başarıyla geri çekildi.');
        } else {
            Session::setFlash('error', 'Başvuru geri çekilirken bir hata oluştu.');
        }
        
        redirect('/applications/my-applications');
    }
}