<?php
require_once __DIR__ . '/../src/routes.php';

header("Content-Type: application/json");

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

$route = parse_url($requestUri, PHP_URL_PATH);
$routes = getRoutes();

if (array_key_exists($route, $routes) && $routes[$route]['method'] === $requestMethod) {
    $handler = $routes[$route]['handler'];
    echo json_encode($handler());
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Not Found']);
}
?>