<?php

// CONEXAO

require_once __DIR__ . '/../init.php';

class Banco
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->conexao();
    }

    public function conexao(): void
    {
        $dsn = 'mysql:host=' . BD_SERVIDOR . ';port=' . BD_PORTA . ';dbname=' . BD_BANCO . ';charset=utf8mb4';
        $this->pdo = new PDO($dsn, BD_USUARIO, BD_SENHA, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // prepared statements reais, executados pelo MySQL
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
