<?php
require_once __DIR__ . '/../model/cliente.php';

exigirLogin();
verificarCsrf();

$id = filter_input(INPUT_POST, 'cl_id', FILTER_VALIDATE_INT);

if ($id && (new Cliente())->excluir($id)) {
    flash('sucesso', 'Cliente excluído com sucesso!');
} else {
    flash('erro', 'Não foi possível excluir o cliente.');
}

redirecionar('../view/clientes.php');
