<?php
// Router sınıfını başlat
$router = new Router();

// Ana sayfa rotası
$router->add('/', 'HomeController', 'index', 'GET');

// Turnuvalar
$router->add('/tournaments', 'TournamentController', 'index', 'GET');
$router->add('/tournaments/view', 'TournamentController', 'view', 'GET');
$router->add('/tournaments/register', 'TournamentController', 'register', 'POST');

// Takımlar
$router->add('/teams', 'TeamController', 'index', 'GET');
$router->add('/teams/view', 'TeamController', 'view', 'GET');
$router->add('/teams/create', 'TeamController', 'create', 'POST');
$router->add('/teams/pending-invitations', 'TeamController', 'pendingInvitations', 'GET');
$router->add('/teams/invite', 'TeamController', 'invite', 'POST');
$router->add('/teams/create', 'TeamController', 'createForm', 'GET');
$router->add('/teams/create/submit', 'TeamController', 'create', 'POST');

// Takım davetleri için rotalar
$router->add('/teams/invitations', 'TeamController', 'myInvitations', 'GET');
$router->add('/teams/accept-invitation', 'TeamController', 'acceptInvitation', 'GET');
$router->add('/teams/reject-invitation', 'TeamController', 'rejectInvitation', 'POST');
$router->add('/teams/join', 'TeamController', 'join', 'GET');
$router->add('/teams/cancel-invitation', 'TeamController', 'cancelInvitation', 'POST');


// Kullanıcılar
$router->add('/register', 'UserController', 'register', 'GET');
$router->add('/register/submit', 'UserController', 'registerSubmit', 'POST');
$router->add('/login', 'UserController', 'login', 'GET');
$router->add('/login/submit', 'UserController', 'loginSubmit', 'POST');
$router->add('/logout', 'UserController', 'logout', 'GET');
$router->add('/profile', 'UserController', 'profile', 'GET');
$router->add('/profile/update', 'UserController', 'updateProfile', 'POST');

// Player Profiles
$router->add('/player/profile', 'PlayerController', 'profile', 'GET');
$router->add('/player/profile/update', 'PlayerController', 'updateProfile', 'POST');
$router->add('/player/profile/create', 'PlayerController', 'createProfileForm', 'GET');
$router->add('/player/profile/create', 'PlayerController', 'createProfile', 'POST');


// Applications
$router->add('/applications/apply', 'ApplicationController', 'apply', 'POST');
$router->add('/applications/my-applications', 'ApplicationController', 'myApplications', 'GET');
$router->add('/applications/team-applications', 'ApplicationController', 'teamApplications', 'GET');
$router->add('/applications/accept', 'ApplicationController', 'accept', 'POST');
$router->add('/applications/reject', 'ApplicationController', 'reject', 'POST');
$router->add('/applications/withdraw', 'ApplicationController', 'withdraw', 'POST');


// Admin paneli
$router->add('/admin', 'AdminController', 'index', 'GET');
$router->add('/admin/tournaments', 'AdminController', 'tournaments', 'GET');
$router->add('/admin/teams', 'AdminController', 'teams', 'GET');
$router->add('/admin/users', 'AdminController', 'users', 'GET');
$router->add('/admin/create-tournament', 'AdminController', 'createTournament', 'POST');
$router->add('/admin/update-tournament-status', 'AdminController', 'updateTournamentStatus', 'POST');
$router->add('/admin/delete-tournament', 'AdminController', 'deleteTournament', 'POST');
$router->add('/admin/generate-matches', 'AdminController', 'generateMatches', 'POST');
$router->add('/admin/delete-team', 'AdminController', 'deleteTeam', 'POST');
$router->add('/admin/delete-user', 'AdminController', 'deleteUser', 'POST');
$router->add('/admin/update-user-role', 'AdminController', 'updateUserRole', 'POST');
$router->add('/admin/approve-registration', 'AdminController', 'approveRegistration', 'POST');
$router->add('/admin/reject-registration', 'AdminController', 'rejectRegistration', 'POST');
$router->add('/admin/tournaments/edit', 'AdminController', 'editTournament', 'GET');
$router->add('/admin/update-tournament', 'AdminController', 'updateTournament', 'POST');

// Team Listings (Job Postings)
$router->add('/teams/listings', 'TeamListingController', 'index', 'GET');
$router->add('/teams/listings/create', 'TeamListingController', 'createForm', 'GET');
$router->add('/teams/listings/create', 'TeamListingController', 'create', 'POST');
$router->add('/teams/listings/view', 'TeamListingController', 'view', 'GET');
$router->add('/teams/listings/edit', 'TeamListingController', 'editForm', 'GET');
$router->add('/teams/listings/update', 'TeamListingController', 'update', 'POST');
$router->add('/teams/listings/delete', 'TeamListingController', 'delete', 'POST');
$router->add('/teams/listings/my-listings', 'TeamListingController', 'myListings', 'GET');

// Bildirimler
$router->add('/notifications/mark-as-read', 'NotificationController', 'markAsRead', 'POST');
$router->add('/notifications/mark-all-as-read', 'NotificationController', 'markAllAsRead', 'POST');
$router->add('/notifications/count', 'NotificationController', 'count', 'GET');


// Test rotası
// $router->add('/test', 'HomeController', 'test', 'GET');