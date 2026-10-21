<?php

// Configuração central, incluída por todos os controllers e views.

require_once __DIR__ . '/lib/funcoes.php';

carregarEnv(__DIR__ . '/.env');

// conexão com o banco de dados (valores vêm do .env ou das variáveis do container)
define('BD_SERVIDOR', env('DB_HOST', 'localhost'));
define('BD_PORTA', env('DB_PORT', '3306'));
define('BD_USUARIO', env('DB_USER', 'root'));
define('BD_SENHA', env('DB_PASSWORD', ''));
define('BD_BANCO', env('DB_NAME', 'sgs'));

// Erros vão para o log, nunca para a tela.
ini_set('display_errors', '0');
set_exception_handler(function (Throwable $erro) {
    error_log((string) $erro);
    http_response_code(500);
    echo 'Ocorreu um erro inesperado. Verifique se o banco de dados está no ar e tente novamente.';
});

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();
