<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | Pizzaria do BernaShow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="assets/css/pizzaria.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg pizza-navbar sticky-top">
    <div class="container page-container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="painel.php"><span aria-hidden="true">🍕</span> Pizzaria do BernaShow</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal" aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item"><a class="nav-link active" href="painel.php">Painel</a></li>
                <?php if (($_SESSION['usuario_perfil'] ?? '') === 'ADMIN'): ?>
                    <li class="nav-item"><a class="nav-link " href="clientes.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link " href="pizzas.php">Cardápio</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link " href="pedidos.php">Pedidos</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-outline-primary btn-sm px-3" href="sair.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container page-container py-4 py-lg-5">
    <section class="dashboard-welcome mb-4 mb-lg-5">
        <p class="text-uppercase small fw-bold mb-2">Painel de controle</p>
        <h1 class="mb-2">Olá, <?= htmlspecialchars($_SESSION['usuario_nome'] ?? 'Usuário', ENT_QUOTES, 'UTF-8') ?>!</h1>
        <p class="mb-0">Acesse uma das áreas abaixo para continuar trabalhando.</p>
        <div class="mt-3"><span class="badge text-bg-light text-danger px-3 py-2">Perfil: <?= htmlspecialchars($_SESSION['usuario_perfil'] ?? 'ATENDENTE', ENT_QUOTES, 'UTF-8') ?></span></div>
    </section>

    <div class="page-heading">
        <div><h2 class="mb-1">Menu principal</h2><p>Escolha o que você precisa fazer.</p></div>
    </div>

    <div class="row g-3 g-lg-4">
        <?php if (($_SESSION['usuario_perfil'] ?? '') === 'ADMIN'): ?>
        <div class="col-md-6 col-xl-4">
            <a href="clientes.php" class="dashboard-card">
                <div class="card-icon mb-3">👥</div>
                <div class="card-title mb-2">Área de clientes</div>
                <p>Cadastre, pesquise e atualize os dados dos clientes.</p>
                <span class="btn btn-outline-primary mt-4">Abrir clientes <span aria-hidden="true">→</span></span>
            </a>
        </div>
        <div class="col-md-6 col-xl-4">
            <a href="pizzas.php" class="dashboard-card">
                <div class="card-icon mb-3">🍕</div>
                <div class="card-title mb-2">Cardápio de pizzas</div>
                <p>Cadastre sabores, ingredientes, tamanhos e preços.</p>
                <span class="btn btn-outline-primary mt-4">Gerenciar cardápio <span aria-hidden="true">→</span></span>
            </a>
        </div>
        <?php endif; ?>
        <div class="col-md-6 col-xl-4">
            <a href="pedidos.php" class="dashboard-card">
                <div class="card-icon mb-3">🧾</div>
                <div class="card-title mb-2">Pedidos</div>
                <p>Registre pedidos escolhendo um cliente e uma pizza do cardápio.</p>
                <span class="btn btn-primary mt-4">Abrir pedidos <span aria-hidden="true">→</span></span>
            </a>
        </div>
    </div>
    <footer class="page-footer">Pizzaria do BernaShow · Sistema de gerenciamento</footer>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
