<?php
require_once __DIR__ . '/../model/usuario.php';

verificarCsrf();

$login = trim((string) ($_POST['login'] ?? ''));
$senha = (string) ($_POST['senha'] ?? '');

if ($login === '' || $senha === '') {
    flash('erro', 'Informe login e senha.');
    redirecionar('../index.php');
}

$usuario = (new Usuario())->pesquisarPorLogin($login);

// a senha fica no banco como hash (password_hash), nunca em texto puro
if (!$usuario || !password_verify($senha, $usuario['senha'])) {
    flash('erro', 'Login ou senha inválidos.');
    redirecionar('../index.php');
}

session_regenerate_id(true);
$_SESSION['usuario'] = ['id' => $usuario['id'], 'nome' => $usuario['nome']];

redirecionar('../view/menu.php');
