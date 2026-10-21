<?php
require_once __DIR__ . '/init.php';

if (!empty($_SESSION['usuario'])) {
    redirecionar('view/menu.php');
}

$titulo = 'Entrar';
$raiz = '.';
$flash = pegarFlash();
?>
<!DOCTYPE html>
<html lang="pt-br">

<?php include __DIR__ . '/view/head.php'; ?>

<body>
    <div class="container">
        <div class="content first-content">
            <div class="first-column">
                <h2 class="title title-primary">SISTEMA DE GERENCIAMENTO</h2>
            </div>
            <div class="second-column">

                <p class="description description-second">INFORME SEUS DADOS:</p>
                <?php if ($flash): ?>
                    <div class="alert alert-<?= $flash['tipo'] === 'sucesso' ? 'success' : 'danger' ?> mensagem-login" role="alert"><?= e($flash['mensagem']) ?></div>
                <?php endif; ?>
                <form method="post" action="controller/ControllerEntrar.php" class="form">
                    <?= campoCsrf() ?>
                    <label class="label-input">
                        <i class="far fa-user icon-modify"></i>
                        <input id="login" name="login" type="text" placeholder="Login" maxlength="50" autocomplete="username" required>
                    </label>

                    <label class="label-input">
                        <i class="fas fa-lock icon-modify"></i>
                        <input id="senha" name="senha" type="password" placeholder="Senha" autocomplete="current-password" required>
                    </label>

                    <button type="submit" class="btn btn-second">Entrar</button>
                </form>
                <p class="demo">Acesso de demonstração: <strong>admin</strong> / <strong>admin123</strong></p>
            </div>
        </div>
    </div>
</body>
</html>
