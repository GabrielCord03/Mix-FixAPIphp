<?php
<?php
require_once 'SpotifyService.php';
require_once 'PlaylistService.php';

$spotifyService = new SpotifyService();
$playlistService = new PlaylistService();

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


$router->post('/api/playlists', function() use ($playlistService) {
    $input = json_decode(file_get_contents('php://input'), true);
    $novaPlaylist = $playlistService->adicionarPlaylist($input);
    if (isset($novaPlaylist['erro'])) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode($novaPlaylist);
        exit;
    }
    http_response_code(201);
    header('Content-Type: application/json');
    echo json_encode($novaPlaylist);
    exit;
});


$router->get('/api/playlists/{id}', function($id) use ($playlistService) {
    $playlist = $playlistService->buscarPlaylistPorId($id);
    if ($playlist) {
        header('Content-Type: application/json');
        echo json_encode($playlist);
    } else {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['erro' => 'Playlist não encontrada.']);
    }
    exit;
});

$router->put('/api/playlists/{id}', function($id) use ($playlistService) {
    $input = json_decode(file_get_contents('php://input'), true);
    $playlist = $playlistService->buscarPlaylistPorId($id);
    if (!$playlist) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['erro' => 'Playlist não encontrada.']);
        exit;
    }
    $atualizada = $playlistService->atualizarPlaylist($id, $input);
    if (isset($atualizada['erros'])) {
        http_response_code(400);
        header('Content-Type: application/json');
        echo json_encode(['erros' => $atualizada['erros']]);
        exit;
    }
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($atualizada);
    exit;
});

$router->delete('/api/playlists/{id}', function($id) use ($playlistService) {
    $playlist = $playlistService->buscarPlaylistPorId($id);
    if (!$playlist) {
        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['erro' => 'Playlist não encontrada.']);
        exit;
    }
    $playlistService->excluirPlaylist($id);
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode(['mensagem' => 'Playlist excluída com sucesso.']);
    exit;
});

$app = new \Slim\App();
$app->group('/api', function() use ($router) {
    $router->dispatch();
});