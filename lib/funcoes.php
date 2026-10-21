<?php

// Funções de apoio usadas por controllers e views.

// Lê um arquivo .env (CHAVE=valor) sem sobrescrever variáveis já definidas no ambiente.
function carregarEnv(string $arquivo): void
{
    if (!is_readable($arquivo)) {
        return;
    }
    foreach (file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $linha) {
        $linha = trim($linha);
        if ($linha === '' || $linha[0] === '#' || strpos($linha, '=') === false) {
            continue;
        }
        [$chave, $valor] = array_map('trim', explode('=', $linha, 2));
        if (getenv($chave) === false) {
            putenv($chave . '=' . trim($valor, "\"'"));
        }
    }
}

function env(string $chave, ?string $padrao = null): ?string
{
    $valor = getenv($chave);
    return $valor === false ? $padrao : $valor;
}

// Escapa qualquer valor antes de imprimir no HTML (proteção contra XSS).
function e($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirecionar(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function exigirLogin(): void
{
    if (empty($_SESSION['usuario'])) {
        flash('erro', 'Faça login para continuar.');
        redirecionar('../index.php');
    }
}

// CSRF: todo formulário que altera dados envia este token.
function csrfToken(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function campoCsrf(): string
{
    return '<input type="hidden" name="csrf" value="' . e(csrfToken()) . '">';
}

function verificarCsrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals(csrfToken(), (string) ($_POST['csrf'] ?? ''))) {
        http_response_code(400);
        exit('Requisição inválida. Volte e tente novamente.');
    }
}

// Mensagens que sobrevivem a um redirecionamento.
function flash(string $tipo, string $mensagem): void
{
    $_SESSION['flash'] = ['tipo' => $tipo, 'mensagem' => $mensagem];
}

function pegarFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

// Guarda o que foi digitado e os erros para reexibir o formulário após o redirecionamento.
function guardarFormulario(array $dados, array $erros): void
{
    $_SESSION['formulario'] = ['dados' => $dados, 'erros' => $erros];
}

function pegarFormulario(): ?array
{
    $formulario = $_SESSION['formulario'] ?? null;
    unset($_SESSION['formulario']);
    return $formulario;
}

function somenteDigitos(string $valor): string
{
    return preg_replace('/\D/', '', $valor);
}

function formatarCpf(?string $cpf): string
{
    return $cpf && strlen($cpf) === 11
        ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf)
        : (string) $cpf;
}
