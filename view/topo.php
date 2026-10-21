<nav class="nav topo">
    <a class="btn-nav" href="menu.php"><i class="fas fa-home"></i> Menu</a>
    <a class="btn-nav" href="clientes.php"><i class="fas fa-users"></i> Clientes</a>

    <span class="topo-usuario">Olá, <?= e($_SESSION['usuario']['nome']) ?></span>
    <form method="post" action="../controller/ControllerSair.php" class="topo-sair">
        <?= campoCsrf() ?>
        <button type="submit" class="btn-nav"><i class="fas fa-sign-out-alt"></i> Sair</button>
    </form>
</nav>

<?php $flash = pegarFlash(); ?>
<?php if ($flash): ?>
    <div class="alert alert-<?= $flash['tipo'] === 'sucesso' ? 'success' : 'danger' ?> mensagem" role="alert"><?= e($flash['mensagem']) ?></div>
<?php endif; ?>
