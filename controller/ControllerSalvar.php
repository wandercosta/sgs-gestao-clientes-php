<?php
require_once __DIR__ . '/../model/cliente.php';

exigirLogin();
verificarCsrf();

$id = filter_input(INPUT_POST, 'cl_id', FILTER_VALIDATE_INT) ?: null;
$voltar = '../view/cadastrarCliente.php' . ($id ? '?id=' . $id : '');

[$dados, $erros] = Cliente::validar($_POST);

if (!$erros) {
    try {
        $cliente = new Cliente();
        if ($id) {
            $cliente->atualizar($id, $dados);
        } else {
            $cliente->incluir($dados);
        }
        flash('sucesso', $id ? 'Cliente atualizado com sucesso!' : 'Cliente cadastrado com sucesso!');
        redirecionar('../view/clientes.php');
    } catch (PDOException $erro) {
        // 1062 = chave duplicada (o CPF é único)
        if (($erro->errorInfo[1] ?? null) !== 1062) {
            throw $erro;
        }
        $erros['cl_cpf'] = 'Já existe um cliente com este CPF.';
    }
}

guardarFormulario($dados, $erros);
redirecionar($voltar);
