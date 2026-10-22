<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (!in_array($_SESSION['usuario_perfil'] ?? '', ['ADMIN', 'ATENDENTE'], true)) {
    http_response_code(403);
    exit("Acesso negado.");
}

require_once 'conexao.php';

$mensagem = '';
$tipoMensagem = 'danger';

// Lê os valores permitidos diretamente da coluna status.
require_once 'status_pedido.php';
$statusValidos = obterStatusPermitidos($pdo);

if (isset($_GET['pedido_cadastrado'])) {
    $mensagem = 'Pedido cadastrado com sucesso!';
    $tipoMensagem = 'success';
} elseif (isset($_GET['pedido_atualizado'])) {
    $mensagem = 'Pedido atualizado com sucesso!';
    $tipoMensagem = 'success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idCliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
    $idPizza = filter_input(INPUT_POST, 'id_pizza', FILTER_VALIDATE_INT);
    $dataPedido = $_POST['data_pedido'] ?? '';
    $dataEntrega = $_POST['data_entrega'] ?? '';
    $status = $_POST['status'] ?? '';

    $dataPedidoObj = DateTime::createFromFormat('!Y-m-d\\TH:i', $dataPedido);
    $dataEntregaObj = DateTime::createFromFormat('!Y-m-d\\TH:i', $dataEntrega);

    if (!$idCliente || !$idPizza || !$dataPedidoObj || !$dataEntregaObj ||
        $dataPedidoObj->format('Y-m-d\\TH:i') !== $dataPedido ||
        $dataEntregaObj->format('Y-m-d\\TH:i') !== $dataEntrega ||
        !in_array($status, $statusValidos, true)) {
        $mensagem = 'Confira o cliente, a pizza, as datas e o status selecionado.';
    } elseif ($dataEntregaObj < $dataPedidoObj) {
        $mensagem = 'A data de entrega não pode ser anterior à data do pedido.';
    } else {
        $stmt = $pdo->prepare("SELECT id_cliente FROM clientes WHERE id_cliente = :id");
        $stmt->execute([':id' => $idCliente]);
        $clienteExiste = $stmt->fetch();

        $stmt = $pdo->prepare("SELECT id_pizza FROM pizzas WHERE id_pizza = :id");
        $stmt->execute([':id' => $idPizza]);
        $pizzaExiste = $stmt->fetch();

        if (!$clienteExiste || !$pizzaExiste) {
            $mensagem = 'O cliente ou a pizza selecionada não existe.';
        } else {
            $sql = "INSERT INTO pedidos
                    (id_cliente, id_pizza, id_usuario, data_pedido, data_entrega, status)
                    VALUES
                    (:id_cliente, :id_pizza, :id_usuario, :data_pedido, :data_entrega, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_cliente' => $idCliente,
                ':id_pizza' => $idPizza,
                ':id_usuario' => $_SESSION['id_usuario'],
                ':data_pedido' => $dataPedidoObj->format('Y-m-d H:i:s'),
                ':data_entrega' => $dataEntregaObj->format('Y-m-d H:i:s'),
                ':status' => $status
            ]);
            header("Location: pedidos.php?pedido_cadastrado=1");
            exit;
        }
    }
}

$clientes = $pdo->query("SELECT id_cliente, nome FROM clientes ORDER BY nome")->fetchAll();
$pizzas = $pdo->query("SELECT id_pizza, sabor, tamanho, preco FROM pizzas ORDER BY sabor")->fetchAll();

$sqlPedidos = "SELECT pe.id_pedido, c.nome AS nome_cliente, pi.sabor AS sabor_pizza,
                      pi.tamanho, pi.preco, pe.data_pedido, pe.data_entrega, pe.status
               FROM pedidos pe
               INNER JOIN clientes c ON c.id_cliente = pe.id_cliente
               INNER JOIN pizzas pi ON pi.id_pizza = pe.id_pizza
               ORDER BY pe.data_pedido DESC";
$pedidos = $pdo->query($sqlPedidos)->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos | Pizzaria do BernaShow</title>
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
    <header class="page-heading">
        <div><h1 class="mb-2">Área de pedidos</h1><p>Registre novos pedidos e acompanhe a situação de cada um.</p></div>
        <a href="painel.php" class="btn btn-outline-secondary">← Voltar ao painel</a>
    </header>

    <?php if ($mensagem !== ''): ?>
        <div class="alert alert-<?= $tipoMensagem ?>" role="alert"><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <section class="content-card mb-4">
        <div class="card-heading"><span class="card-icon">＋</span><div><h2 class="mb-1">Novo pedido</h2><p class="text-secondary small mb-0">Selecione um cliente, uma pizza e os horários.</p></div></div>
        <?php if (empty($clientes)): ?>
            <div class="alert alert-info mb-0">Ainda não existem clientes cadastrados. Peça ao administrador para cadastrar um cliente.</div>
        <?php elseif (empty($pizzas)): ?>
            <div class="alert alert-info mb-0">O cardápio está vazio. Peça ao administrador para cadastrar pizzas.</div>
        <?php else: ?>
        <form action="pedidos.php" method="POST" class="row g-3">
            <div class="col-md-6"><label for="id_cliente" class="form-label">Cliente</label><select class="form-select" id="id_cliente" name="id_cliente" required><option value="">Selecione um cliente</option><?php foreach ($clientes as $cliente): ?><option value="<?= (int) $cliente['id_cliente'] ?>"><?= htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?></select></div>
            <div class="col-md-6"><label for="id_pizza" class="form-label">Pizza do cardápio</label><select class="form-select" id="id_pizza" name="id_pizza" required><option value="">Selecione uma pizza</option><?php foreach ($pizzas as $pizza): ?><option value="<?= (int) $pizza['id_pizza'] ?>"><?= htmlspecialchars($pizza['sabor'], ENT_QUOTES, 'UTF-8') ?> · <?= htmlspecialchars($pizza['tamanho'], ENT_QUOTES, 'UTF-8') ?> · R$ <?= number_format((float) $pizza['preco'], 2, ',', '.') ?></option><?php endforeach; ?></select></div>
            <div class="col-md-4"><label for="data_pedido" class="form-label">Data e hora do pedido</label><input type="datetime-local" class="form-control" id="data_pedido" name="data_pedido" required></div>
            <div class="col-md-4"><label for="data_entrega" class="form-label">Previsão de entrega</label><input type="datetime-local" class="form-control" id="data_entrega" name="data_entrega" required></div>
            <div class="col-md-4"><label for="status" class="form-label">Status inicial</label><select class="form-select" id="status" name="status" required><?php foreach ($statusValidos as $valor): ?><option value="<?= htmlspecialchars($valor, ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars(rotuloStatusPedido($valor), ENT_QUOTES, 'UTF-8') ?></option><?php endforeach; ?></select></div>
            <div class="col-12"><button type="submit" class="btn btn-primary">Registrar pedido</button></div>
        </form>
        <?php endif; ?>
    </section>

    <section class="content-card">
        <div class="card-heading"><span class="card-icon">☷</span><div><h2 class="mb-1">Pedidos registrados</h2><p class="text-secondary small mb-0">Lista organizada dos pedidos recentes.</p></div></div>
        <div class="d-flex justify-content-end mb-3"><span class="badge rounded-pill text-bg-light border"><?= count($pedidos) ?> pedido(s)</span></div>
        <div class="table-responsive table-wrap">
            <table class="table table-hover">
                <thead><tr><th>ID</th><th>Cliente</th><th>Pizza</th><th>Tamanho</th><th>Preço</th><th>Pedido</th><th>Entrega</th><th>Status</th><?php if (($_SESSION['usuario_perfil'] ?? '') === 'ADMIN'): ?><th>Ação</th><?php endif; ?></tr></thead>
                <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td class="text-secondary">#<?= (int) $pedido['id_pedido'] ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($pedido['nome_cliente'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($pedido['sabor_pizza'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><span class="badge text-bg-light border"><?= htmlspecialchars($pedido['tamanho'], ENT_QUOTES, 'UTF-8') ?></span></td>
                        <td class="text-nowrap">R$ <?= number_format((float) $pedido['preco'], 2, ',', '.') ?></td>
                        <td class="text-nowrap small"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($pedido['data_pedido'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td class="text-nowrap small"><?= htmlspecialchars(date('d/m/Y H:i', strtotime($pedido['data_entrega'])), ENT_QUOTES, 'UTF-8') ?></td>
                        <td><span class="badge-status"><?= htmlspecialchars(rotuloStatusPedido($pedido['status']), ENT_QUOTES, 'UTF-8') ?></span></td>
                        <?php if (($_SESSION['usuario_perfil'] ?? '') === 'ADMIN'): ?><td><a class="btn btn-sm btn-outline-primary" href="editarPedido.php?id=<?= (int) $pedido['id_pedido'] ?>">Editar</a></td><?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($pedidos)): ?><tr><td colspan="<?= (($_SESSION['usuario_perfil'] ?? '') === 'ADMIN') ? 9 : 8 ?>" class="empty-state">Nenhum pedido registrado ainda.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer class="page-footer">Pizzaria do BernaShow · Área de pedidos</footer>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
