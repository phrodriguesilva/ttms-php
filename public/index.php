<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Verifica se é uma rota da API
if (str_starts_with($_SERVER['REQUEST_URI'], '/api')) {
    // Carrega o Laravel normalmente para rotas da API
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Kernel::class);
    $response = $kernel->handle(
        $request = Request::capture()
    )->send();
    $kernel->terminate($request, $response);
} else {
    // Para todas as outras rotas, serve o app Nuxt
    $indexPath = __DIR__ . '/_nuxt/index.html';
    
    if (file_exists($indexPath)) {
        readfile($indexPath);
        exit;
    } else {
        // Se o index.html não existir, mostra um erro
        http_response_code(404);
        echo "Nuxt application not found. Please build the frontend application.";
    }
}
