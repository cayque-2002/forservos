<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/env.php';

use Src\Middleware\MiddlewareHandler;
use Src\Core\ExceptionHandler;

// Exception global
set_exception_handler([ExceptionHandler::class, 'handle']);

// Headers
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// URL e método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Rotas
$routes = [
    'usuario' => [
        '_controller' => 'Src\\Controllers\\UsuarioController',
        'create' => [
            'method' => 'POST',
            'middlewares' => ['auth', 'role:admin']
        ],
        'list' => [
            'method' => 'GET',
            'middlewares' => ['auth', 'role:admin,user']
        ],
        'update' => [
            'method' => 'PUT',
            'middlewares' => ['auth', 'role:admin']
        ],
        'delete' => [
            'method' => 'DELETE',
            'middlewares' => ['auth', 'role:admin']
        ]
    ],
    'roleusuarios' => [
        '_controller' => 'Src\\Controllers\\RoleUsuariosController',
        'create' => [
            'method' => 'POST',
            'middlewares' => ['auth', 'role:admin']
        ],
        'list' => [
            'method' => 'GET',
            'middlewares' => ['auth', 'role:admin,user']
        ],
        'update' => [
            'method' => 'PUT',
            'middlewares' => ['auth', 'role:admin']
        ],
        'delete' => [
            'method' => 'DELETE',
            'middlewares' => ['auth', 'role:admin']
        ]
    ],
    'estado' => [
        '_controller' => 'Src\\Controllers\\EstadoController',
        'create' => [
            'method' => 'POST',
            'middlewares' => ['auth', 'role:admin']
        ],
        'list' => [
            'method' => 'GET',
            'middlewares' => ['auth', 'role:admin,user']
        ],
        'update' => [
            'method' => 'PUT',
            'middlewares' => ['auth', 'role:admin']
        ],
        'delete' => [
            'method' => 'DELETE',
            'middlewares' => ['auth', 'role:admin']
        ]
    ],
    'auth' => [
        '_controller' => 'Src\\Controllers\\AuthController',
        'login' => [
            'method' => 'POST',
            'middlewares' => []
        ]
    ]
];

// Quebra URL
$segments = explode('/', trim($uri, '/'));

$controllerKey = strtolower($segments[0] ?? '');
$action = $segments[1] ?? null;

// validação
if (!$controllerKey || !$action) {
    http_response_code(404);
    echo json_encode(["error" => "Rota inválida"]);
    exit;
}

if (!isset($routes[$controllerKey])) {
    http_response_code(404);
    echo json_encode(["error" => "Controller de rota não encontrado"]);
    exit;
}

if (!isset($routes[$controllerKey][$action])) {
    http_response_code(404);
    echo json_encode(["error" => "Rota não encontrada"]);
    exit;
}

$route = $routes[$controllerKey][$action];

// método errado
if ($method !== $route['method']) {
    http_response_code(405);
    echo json_encode(["error" => "Método não permitido"]);
    exit;
}

// Middlewares
MiddlewareHandler::handle($route['middlewares']);

// Controller
$controllerClass = $routes[$controllerKey]['_controller'];

if (!class_exists($controllerClass)) {
    http_response_code(404);
    echo json_encode(["error" => "Controller não encontrado"]);
    exit;
}

// DI MANUAL
switch ($controllerClass) {
    case "Src\\Controllers\\AuthController":
        $controller = new $controllerClass(
            new \Src\Services\AuthService(
                new \Src\Infrastructure\Repositories\UsuarioRepository()
            )
        );
        break;

    case "Src\\Controllers\\UsuarioController":
        $controller = new $controllerClass(
            new \Src\Services\UsuarioService(
                new \Src\Infrastructure\Repositories\UsuarioRepository()
            )
        );
        break;

    case "Src\\Controllers\\RoleUsuariosController":
        $controller = new $controllerClass(
            new \Src\Services\RoleUsuariosService(
                new \Src\Infrastructure\Repositories\RoleUsuariosRepository()
            )
        );
        break;

    case "Src\\Controllers\\EstadoController":
        $controller = new $controllerClass(
            new \Src\Services\EstadoService(
                new \Src\Infrastructure\Repositories\EstadoRepository()
            )
        );
        break;

    default:
        $controller = new $controllerClass();
        break;
}

// valida ação
if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo json_encode(["error" => "Ação não encontrada"]);
    exit;
}

// Executa
$controller->$action();

?>