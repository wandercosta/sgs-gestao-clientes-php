<?php
require_once __DIR__ . '/banco.php';

class Usuario extends Banco
{
    public function pesquisarPorLogin(string $login): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, nome, login, senha FROM usuarios WHERE login = ?');
        $stmt->execute([$login]);
        return $stmt->fetch() ?: null;
    }
}
