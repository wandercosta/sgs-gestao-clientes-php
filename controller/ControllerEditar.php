<?php
require_once __DIR__ . '/../model/cliente.php';

exigirLogin();

// Prepara os dados do formulário: vazio no cadastro, preenchido na edição.
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: null;
$cliente = ['ativo' => 1];

if ($id) {
    $cliente = (new Cliente())->buscar($id);
    if (!$cliente) {
        flash('erro', 'Cliente não encontrado.');
        redirecionar('clientes.php');
    }
}

// Se o último envio teve erros, reexibe o que foi digitado.
$erros = [];
$formulario = pegarFormulario();
if ($formulario) {
    $cliente = array_merge($cliente, $formulario['dados']);
    $erros = $formulario['erros'];
}
