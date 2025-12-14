<?php
/**
 * Front Controller - Point d'entrée unique de l'application
 */

// Autoloader Composer
require_once __DIR__ . '/vendor/autoload.php';

// Charger les variables d'environnement depuis .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Démarrer la session
session_start();

// Initialiser le routeur
use App\Core\Router;

$router = new Router();

// Définir les routes
$router->get('/', 'HomeController@index');
$router->get('/auth/start', 'AuthController@start');
$router->get('/auth/login', 'AuthController@login');
$router->post('/auth/authenticate', 'AuthController@authenticate');
$router->post('/auth/register', 'AuthController@register');
$router->get('/auth/logout', 'AuthController@logout');
$router->get('/profile', 'ProfileController@show');
$router->get('/profile/create', 'ProfileController@create');
$router->post('/profile/store', 'ProfileController@store');
$router->get('/profile/analysis', 'ProfileController@analysis');
$router->get('/profile/validate', 'ProfileController@validate');
$router->get('/match', 'MatchController@index');
$router->get('/match/detail', 'MatchController@detail');
$router->get('/match/contact-mode', 'MatchController@contactMode');
$router->get('/match/revealed', 'MatchController@revealed');
$router->get('/match/result', 'MatchController@result');
$router->post('/match/accept', 'MatchController@accept');
$router->post('/match/reject', 'MatchController@reject');
$router->post('/match/request-mediation', 'MatchController@requestMediation');
$router->post('/match/end-peacefully', 'MatchController@endPeacefully');
$router->get('/chat', 'ChatController@index');
$router->get('/chat/messages', 'ChatController@getMessages');
$router->post('/chat/send', 'ChatController@send');
$router->get('/dashboard', 'DashboardController@index');

// Dispatcher la requête
$router->dispatch();
