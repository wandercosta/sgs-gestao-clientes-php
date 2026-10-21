<?php
require_once __DIR__ . '/../model/cliente.php';

exigirLogin();

$clientes = (new Cliente())->listar();
