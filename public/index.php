<?php
declare(strict_types=1);
use Dotenv\Dotenv;

// Charger l'autoloader généré par Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Démarrer la session
session_start();

// Charger l'env
$dotenv = Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Récupérer l'URL demandée
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Trouver une route correspondante (avec gestion des paramètres dynamiques)
$routes = require_once __DIR__ . '/../config/routes.php';

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = explode('/', trim($url, '/')); // Divise l'URL en segments
$basePath = '/' . ($parts[0] ?? ''); // Extrait la partie de base (ex. : "/detail")
$argument = isset($parts[1]) ? implode('/', array_slice($parts, 1)) : null; // Concatène tout ce qui suit la première partie

// Vérifier si la route existe
if (isset($routes[$basePath])) {
    $route = $routes[$basePath];
    $controllerClass = $route['controller']; // Classe du contrôleur
    $methods = $route['methods']; // Méthodes autorisées (GET, POST, etc.)
    $redirectRelPath = $route['redirect'] ?? '/'; // Redirection par défaut
    $requiresArgument = $route['requiresArgument']; // Route nécessite un argument ?

    // Construire l'URL de redirection complète
    $protocol = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https' : 'http';
    $redirect = $protocol . "://" . $_SERVER['HTTP_HOST'] . $redirectRelPath;

    // Vérifier si la méthode HTTP est autorisée
    if (!in_array($_SERVER['REQUEST_METHOD'], $methods)) {
        http_response_code(405);
        header("Location: " . $redirect);
        exit();
    }

    // Si un argument est requis mais absent
    if ($requiresArgument && !$argument) {
        http_response_code(400); // Code erreur 400 (bad request)
        echo "Erreur : argument manquant pour la route {$basePath}.";
        exit();
    }

    // Vérifier que la classe du contrôleur existe
    if (!class_exists($controllerClass)) {
        http_response_code(500);
        echo "Erreur : Le contrôleur {$controllerClass} est introuvable.";
        exit();
    }

    // Instancier le contrôleur
    try {
        $controller = new $controllerClass($redirect);

        // Appeler la méthode d'action correspondante
        $action = strtolower($_SERVER['REQUEST_METHOD']);
        if (method_exists($controller, $action)) {
            if ($requiresArgument) {
                $controller->$action($argument); // Passe l'argument au contrôleur
            } else {
                $controller->$action("");
            }
        } else {
            http_response_code(405);
            echo "Erreur : Méthode {$action} non définie dans le contrôleur.";
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo "Erreur du serveur : " . $e->getMessage();
    }
} else {
    // Si aucune route ne correspond
    http_response_code(404);
    require_once __DIR__ . '/../views/error.php';
}