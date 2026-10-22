
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_perfil'] ?? '') !== 'ADMIN') {
    http_response_code(403);
    exit("Acesso negado. Apenas administradores podem acessar esta área.");
}

require_once 'conexao.php';

// Buscar o ID do pedido pela URL
$idPedido = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$idPedido) {
    header("Location: pedidos.php");
    exit;
}

// Buscar os dados do pedido
$sql = "SELECT *
        FROM pedidos
        WHERE id_pedido = :id_pedido";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id_pedido' => $idPedido
]);

$pedido = $stmt->fetch();

if (!$pedido) {
    exit("Pedido não encontrado.");
}

// Buscar clientes
$sql = "SELECT id_cliente, nome
        FROM clientes
        ORDER BY nome";

$clientes = $pdo->query($sql)->fetchAll();

// Buscar pizzas
$sql = "SELECT id_pizza, sabor, tamanho, preco
        FROM pizzas
        ORDER BY sabor";

$pizzas = $pdo->query($sql)->fetchAll();

// Obter os status permitidos diretamente do banco.
require_once 'status_pedido.php';
$statusValidos = [];
foreach (obterStatusPermitidos($pdo) as $status) {
    $statusValidos[$status] = rotuloStatusPedido($status);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar pedido | Pizzaria do BernaShow</title>
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
                <li class="nav-item"><a class="nav-link " href="painel.php">Painel</a></li>
                <?php if (($_SESSION['usuario_perfil'] ?? '') === 'ADMIN'): ?>
                    <li class="nav-item"><a class="nav-link " href="clientes.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link " href="pizzas.php">Cardápio</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link active" href="pedidos.php">Pedidos</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-outline-primary btn-sm px-3" href="sair.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container page-container py-4 py-lg-5">
    <div class="page-heading"><div><h1 class="mb-2">Editar pedido <span class="text-secondary">#<?= (int) $pedido['id_pedido'] ?></span></h1><p>Revise as informações e confirme as alterações.</p></div><a href="pedidos.php" class="btn btn-outline-secondary">← Voltar aos pedidos</a></div>
    <div class="row justify-content-center"><div class="col-lg-8 col-xl-7">
        <section class="content-card">
            <div class="card-heading"><span class="card-icon">🧾</span><div><h2 class="mb-1">Informações do pedido</h2><p class="text-secondary small mb-0">Altere os campos necessários.</p></div></div>
            <form action="atualizarPedido.php" method="POST" class="d-grid gap-3">
                <input type="hidden" name="id_pedido" value="<?= (int) $pedido['id_pedido'] ?>">
                <div><label for="id_cliente" class="form-label">Cliente</label><select class="form-select" name="id_cliente" id="id_cliente" required><option value="">Selecione um cliente</option>
                <?php foreach ($clientes as $cliente): ?><option value="<?= (int) $cliente['id_cliente'] ?>" <?= (int) $pedido['id_cliente'] === (int) $cliente['id_cliente'] ? 'selected' : '' ?>><?= htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?>
                </select></div>
                <div><label for="id_pizza" class="form-label">Pizza</label><select class="form-select" name="id_pizza" id="id_pizza" required><option value="">Selecione uma pizza</option>
                <?php foreach ($pizzas as $pizza): ?><option value="<?= (int) $pizza['id_pizza'] ?>" <?= (int) $pedido['id_pizza'] === (int) $pizza['id_pizza'] ? 'selected' : '' ?>><?= htmlspecialchars($pizza['sabor'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($pizza['tamanho'], ENT_QUOTES, 'UTF-8') ?> - R$ <?= number_format((float) $pizza['preco'], 2, ',', '.') ?></option><?php endforeach; ?>
                </select></div>
                <div class="row g-3"><div class="col-md-6"><label for="data_pedido" class="form-label">Data e hora do pedido</label><input type="datetime-local" class="form-control" id="data_pedido" name="data_pedido" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($pedido['data_pedido'])), ENT_QUOTES, 'UTF-8') ?>" required></div>
                <div class="col-md-6"><label for="data_entrega" class="form-label">Data e hora da entrega</label><input type="datetime-local" class="form-control" id="data_entrega" name="data_entrega" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($pedido['data_entrega'])), ENT_QUOTES, 'UTF-8') ?>" required></div></div>
                <div><label for="status" class="form-label">Status do pedido</label><select class="form-select" name="status" id="status" required><?php foreach ($statusValidos as $valor => $rotulo): ?><option value="<?= htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') ?>" <?= $pedido['status'] === $valor ? 'selected' : '' ?>><?= htmlspecialchars($rotulo, ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?></select></div>
                <div class="d-flex flex-wrap gap-2 pt-2"><button type="submit" class="btn btn-primary">Salvar alterações</button><a href="pedidos.php" class="btn btn-outline-secondary">Cancelar</a></div>
            </form>
        </section>
    </div></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
