<?php
require_once __DIR__ . '/../controller/ControllerListar.php';

$titulo = 'Clientes';
?>
<!DOCTYPE html>
<html lang="pt-br">

<?php include __DIR__ . '/head.php'; ?>

<body>
    <?php include __DIR__ . '/topo.php'; ?>

    <main class="pagina">
        <div class="pagina-cabecalho">
            <h1 class="pagina-titulo">Clientes</h1>
            <a class="btn btn-second" href="cadastrarCliente.php"><i class="fas fa-user-plus"></i> Novo cliente</a>
        </div>

        <input type="search" id="filtro-clientes" class="form-control filtro" placeholder="Buscar por nome, CPF ou cidade" aria-label="Buscar clientes">

        <div class="tabela-rolagem">
            <table class="sortable table table-hover" id="tabela-clientes">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Cidade/UF</th>
                        <th>Situação</th>
                        <th class="sorttable_nosort">Opções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $c): ?>
                        <tr>
                            <td><?= e($c['cl_id']) ?></td>
                            <td><?= e($c['cl_nome']) ?></td>
                            <td><?= e(formatarCpf($c['cl_cpf'])) ?></td>
                            <td><?= e(implode('/', array_filter([$c['cl_cidade'], $c['cl_uf']]))) ?></td>
                            <td>
                                <?php if ($c['ativo']): ?>
                                    <span class="badge badge-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td class="acoes">
                                <a class="btn-pqn btn-warning" href="cadastrarCliente.php?id=<?= e($c['cl_id']) ?>" title="Editar"><i class="fas fa-edit"></i></a>
                                <form method="post" action="../controller/ControllerDeletar.php" class="form-excluir" data-nome="<?= e($c['cl_nome']) ?>">
                                    <?= campoCsrf() ?>
                                    <input type="hidden" name="cl_id" value="<?= e($c['cl_id']) ?>">
                                    <button type="submit" class="btn-pqn btn-danger" title="Excluir"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php if (!$clientes): ?>
                <p class="vazio">Nenhum cliente cadastrado ainda.</p>
            <?php endif; ?>
        </div>
    </main>

    <script src="../js/sorttable.js"></script>
    <script src="../js/app.js"></script>
</body>
</html>
