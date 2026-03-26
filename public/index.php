<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Config/env.php';

header('Content-Type: application/json');

// URL e método
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Mapeamento de rotas
$routes = [
    'usuario' => [
        'create' => 'POST',
        'list' => 'GET'
    ],
    'auth' => [
        'login' => 'POST'
    ]
];

// Quebra da URL
$segments = explode('/', trim($uri, '/'));

$controllerKey = strtolower($segments[0] ?? '');
$action = $segments[1] ?? null;

// Validação básica
if (!$controllerKey || !$action) {
    http_response_code(404);
    echo json_encode(["error" => "Rota inválida"]);
    exit;
}

// Valida rota existente
if (!isset($routes[$controllerKey][$action])) {
    http_response_code(404);
    echo json_encode(["error" => "Rota não encontrada"]);
    exit;
}

// Valida método HTTP
$expectedMethod = $routes[$controllerKey][$action];

if ($method !== $expectedMethod) {
    http_response_code(405);
    echo json_encode(["error" => "Método não permitido"]);
    exit;
}

// Monta controller
$controllerName = ucfirst($controllerKey);
$controllerClass = "Src\\Controllers\\{$controllerName}Controller";

if (!class_exists($controllerClass)) {
    http_response_code(404);
    echo json_encode(["error" => "Controller não encontrado"]);
    exit;
}

$controller = new $controllerClass();

// Segurança extra
if (!method_exists($controller, $action)) {
    http_response_code(404);
    echo json_encode(["error" => "Ação não encontrada"]);
    exit;
}

// Executa ação
$controller->$action();