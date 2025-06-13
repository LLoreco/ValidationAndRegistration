<?php
// Заголовки CORS (обновите домен и порт фронтенда)
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Проверка наличия переменных сервера
$uri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

// Удаляем /backend/public/ из пути, если оно присутствует
$uri = preg_replace('#^/backend/public#', '', $uri, 1) ?: $uri;

require_once __DIR__ . '/../controllers/AuthController.php';

$controller = new AuthController();

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
} elseif ($method === 'POST') {
    switch ($uri) {
        case '/api/register':
            $controller->register();
            break;
        case '/api/login':
            $controller->login();
            break;
        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Not Found']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
?>