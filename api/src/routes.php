<?php
require_once 'SpotifyService.php';

$spotifyService = new SpotifyService();

$router = new \Slim\Routing\RouteCollector(new \Slim\Http\Environment($_SERVER));

$router->get('/api/spotify/auth', function() use ($spotifyService) {
    return $spotifyService->authenticate();
});

$router->get('/api/spotify/tracks', function() use ($spotifyService) {
    return $spotifyService->getTracks();
});

$router->get('/api/spotify/albums', function() use ($spotifyService) {
    return $spotifyService->getAlbums();
});

// Add more routes as needed

$app = new \Slim\App();
$app->group('/api', function() use ($router) {
    $router->dispatch();
});

$app->run();
?>