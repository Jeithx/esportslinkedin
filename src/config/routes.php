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

// Kullanıcılar
$router->add('/register', 'UserController', 'register', 'GET');
$router->add('/register/submit', 'UserController', 'registerSubmit', 'POST');
$router->add('/login', 'UserController', 'login', 'GET');
$router->add('/login/submit', 'UserController', 'loginSubmit', 'POST');
$router->add('/logout', 'UserController', 'logout', 'GET');
$router->add('/profile', 'UserController', 'profile', 'GET');
$router->add('/profile/update', 'UserController', 'updateProfile', 'POST');
$router->add('/teams/invite', 'TeamController', 'invite', 'POST');
$router->add('/teams/create', 'TeamController', 'createForm', 'GET');
$router->add('/teams/create/submit', 'TeamController', 'create', 'POST');



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



// Test rotası - ihtiyaç yoksa kaldırılabilir
// $router->add('/test', 'HomeController', 'test', 'GET');