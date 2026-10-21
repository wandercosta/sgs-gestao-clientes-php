<?php
require_once __DIR__ . '/../controller/ControllerEditar.php';

$titulo = $id ? 'Editar cliente' : 'Novo cliente';

// Classe e mensagem de erro de cada campo
$invalido = fn (string $campo) => isset($erros[$campo]) ? ' is-invalid' : '';
$erro = fn (string $campo) => isset($erros[$campo]) ? '<div class="invalid-feedback">' . e($erros[$campo]) . '</div>' : '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<?php include __DIR__ . '/head.php'; ?>

<body>
    <?php include __DIR__ . '/topo.php'; ?>

    <main class="pagina formulario">
        <h1 class="pagina-titulo"><?= e($titulo) ?></h1>

        <?php if ($erros): ?>
            <div class="alert alert-danger" role="alert">Corrija os campos destacados.</div>
        <?php endif; ?>

        <form action="../controller/ControllerSalvar.php" method="post">
            <?= campoCsrf() ?>
            <?php if ($id): ?>
                <input type="hidden" name="cl_id" value="<?= e($id) ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="cl_nome">Nome *</label>
                <input type="text" class="form-control<?= $invalido('cl_nome') ?>" id="cl_nome" name="cl_nome" value="<?= e($cliente['cl_nome'] ?? '') ?>" minlength="3" maxlength="100" required autofocus>
                <?= $erro('cl_nome') ?>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="cl_cpf">CPF</label>
                    <input type="text" class="form-control<?= $invalido('cl_cpf') ?>" id="cl_cpf" name="cl_cpf" value="<?= e(formatarCpf($cliente['cl_cpf'] ?? '')) ?>" maxlength="14" inputmode="numeric" placeholder="000.000.000-00">
                    <?= $erro('cl_cpf') ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="cl_telefone_01">Telefone 1</label>
                    <input type="tel" class="form-control<?= $invalido('cl_telefone_01') ?>" id="cl_telefone_01" name="cl_telefone_01" value="<?= e($cliente['cl_telefone_01'] ?? '') ?>" maxlength="15" placeholder="(00) 00000-0000">
                    <?= $erro('cl_telefone_01') ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="cl_telefone_02">Telefone 2</label>
                    <input type="tel" class="form-control<?= $invalido('cl_telefone_02') ?>" id="cl_telefone_02" name="cl_telefone_02" value="<?= e($cliente['cl_telefone_02'] ?? '') ?>" maxlength="15">
                    <?= $erro('cl_telefone_02') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="cl_endereco">Endereço</label>
                <input type="text" class="form-control<?= $invalido('cl_endereco') ?>" id="cl_endereco" name="cl_endereco" value="<?= e($cliente['cl_endereco'] ?? '') ?>" maxlength="150">
                <?= $erro('cl_endereco') ?>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cl_cidade">Cidade</label>
                    <input type="text" class="form-control<?= $invalido('cl_cidade') ?>" id="cl_cidade" name="cl_cidade" value="<?= e($cliente['cl_cidade'] ?? '') ?>" maxlength="80">
                    <?= $erro('cl_cidade') ?>
                </div>
                <div class="form-group col-6 col-md-2">
                    <label for="cl_uf">UF</label>
                    <select class="form-control<?= $invalido('cl_uf') ?>" id="cl_uf" name="cl_uf">
                        <option value="">--</option>
                        <?php foreach (Cliente::UFS as $uf): ?>
                            <option value="<?= $uf ?>"<?= ($cliente['cl_uf'] ?? '') === $uf ? ' selected' : '' ?>><?= $uf ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?= $erro('cl_uf') ?>
                </div>
                <div class="form-group col-6 col-md-4">
                    <label for="cl_cep">CEP</label>
                    <input type="text" class="form-control<?= $invalido('cl_cep') ?>" id="cl_cep" name="cl_cep" value="<?= e($cliente['cl_cep'] ?? '') ?>" maxlength="9" inputmode="numeric" placeholder="00000-000">
                    <?= $erro('cl_cep') ?>
                </div>
            </div>

            <div class="form-group">
                <label for="cl_obs">Observações</label>
                <textarea class="form-control<?= $invalido('cl_obs') ?>" id="cl_obs" name="cl_obs" rows="4" maxlength="500"><?= e($cliente['cl_obs'] ?? '') ?></textarea>
                <?= $erro('cl_obs') ?>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1"<?= !empty($cliente['ativo']) ? ' checked' : '' ?>>
                <label class="form-check-label" for="ativo">Cliente ativo</label>
            </div>

            <div class="botoes">
                <a class="btn btn-light" href="clientes.php">Cancelar</a>
                <button type="submit" class="btn btn-second">Salvar</button>
            </div>
        </form>
    </main>
</body>
</html>
