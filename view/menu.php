<?php
require_once __DIR__ . '/../init.php';
exigirLogin();

$titulo = 'Menu';
?>
<!DOCTYPE html>
<html lang="pt-br">

<?php include __DIR__ . '/head.php'; ?>

<body>
    <?php include __DIR__ . '/topo.php'; ?>

    <main class="pagina">
        <h1 class="pagina-titulo">Menu</h1>
        <div class="menu-grade">
            <a class="btn-menu" href="clientes.php"><span class="fa fa-user fa-2x"></span> Clientes</a>
            <!-- módulos planejados em 2021 que não chegaram a sair do papel -->
            <span class="btn-menu" aria-disabled="true"><span class="fas fa-car fa-2x"></span> Veículos <small>em breve</small></span>
            <span class="btn-menu" aria-disabled="true"><span class="fas fa-tools fa-2x"></span> Serviços <small>em breve</small></span>
            <span class="btn-menu" aria-disabled="true"><span class="fas fa-store fa-2x"></span> Estoque <small>em breve</small></span>
        </div>
    </main>
</body>
</html>
