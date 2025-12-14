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
$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/register', 'AuthController@register');
$router->get('/profile/create', 'ProfileController@create');
$router->post('/profile/store', 'ProfileController@store');
$router->get('/match', 'MatchController@index');
$router->get('/match/detail', 'MatchController@detail');
$router->get('/match/result', 'MatchController@result');
$router->get('/chat', 'ChatController@index');
$router->post('/chat/send', 'ChatController@send');

// Dispatcher la requête
$router->dispatch();
