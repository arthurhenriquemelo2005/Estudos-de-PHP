
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

$mensagem = '';

// Cadastrar pizza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sabor = trim($_POST['sabor'] ?? '');
    $ingredientes = trim($_POST['ingredientes'] ?? '');
    $tamanho = $_POST['tamanho'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $personalizada = isset($_POST['personalizada']) ? 1 : 0;

    if (
        $sabor === '' ||
        $ingredientes === '' ||
        mb_strlen($sabor) > 100 ||
        !in_array($tamanho, ['PEQUENA', 'MEDIA', 'GRANDE'], true) ||
        !is_numeric($preco) ||
        (float) $preco <= 0
    ) {
        $mensagem = 'Preencha os dados da pizza corretamente.';
    } else {
        $sql = "INSERT INTO pizzas
                (sabor, ingredientes, tamanho, preco, personalizada)
                VALUES
                (:sabor, :ingredientes, :tamanho, :preco, :personalizada)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':sabor' => $sabor,
            ':ingredientes' => $ingredientes,
            ':tamanho' => $tamanho,
            ':preco' => $preco,
            ':personalizada' => $personalizada
        ]);

        header("Location: pizzas.php?sucesso=1");
        exit;
    }
}

if (isset($_GET['sucesso'])) {
    $mensagem = 'Pizza cadastrada com sucesso!';
}

// Listar pizzas
$sql = "SELECT
            id_pizza,
            sabor,
            ingredientes,
            tamanho,
            preco,
            personalizada
        FROM pizzas
        ORDER BY id_pizza DESC";

$pizzas = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio | Pizzaria do BernaShow</title>
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
                    <li class="nav-item"><a class="nav-link active" href="pizzas.php">Cardápio</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link " href="pedidos.php">Pedidos</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-outline-primary btn-sm px-3" href="sair.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container page-container py-4 py-lg-5">
    <header class="page-heading">
        <div><h1 class="mb-2">Cardápio de pizzas</h1><p>Cadastre os sabores e mantenha preços e ingredientes organizados.</p></div>
        <a href="painel.php" class="btn btn-outline-secondary">← Voltar ao painel</a>
    </header>

    <?php if ($mensagem !== ''): ?>
        <div class="alert alert-success" role="alert"><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <div class="row g-4 align-items-start">
        <div class="col-lg-4">
            <section class="content-card">
                <div class="card-heading"><span class="card-icon">🍕</span><div><h2 class="mb-1">Nova pizza</h2><p class="text-secondary small mb-0">Adicione uma opção ao cardápio.</p></div></div>
                <form action="pizzas.php" method="POST" class="d-grid gap-3">
                    <div><label for="sabor" class="form-label">Sabor</label><input type="text" class="form-control" id="sabor" name="sabor" maxlength="100" placeholder="Ex.: Calabresa" required></div>
                    <div><label for="ingredientes" class="form-label">Ingredientes</label><textarea class="form-control" id="ingredientes" name="ingredientes" rows="3" placeholder="Liste os principais ingredientes" required></textarea></div>
                    <div><label for="tamanho" class="form-label">Tamanho</label><select class="form-select" id="tamanho" name="tamanho" required><option value="">Selecione o tamanho</option><option value="PEQUENA">Pequena</option><option value="MEDIA">Média</option><option value="GRANDE">Grande</option></select></div>
                    <div><label for="preco" class="form-label">Preço (R$)</label><input type="number" class="form-control" id="preco" name="preco" min="0.01" step="0.01" placeholder="0,00" required></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox" id="personalizada" name="personalizada" value="1"><label class="form-check-label" for="personalizada">Pizza personalizada</label></div>
                    <button type="submit" class="btn btn-primary">Cadastrar pizza</button>
                </form>
            </section>
        </div>
        <div class="col-lg-8">
            <section class="content-card">
                <div class="card-heading"><span class="card-icon">☷</span><div><h2 class="mb-1">Pizzas cadastradas</h2><p class="text-secondary small mb-0">Confira sabores, tamanhos e preços disponíveis.</p></div></div>
                <div class="d-flex justify-content-end mb-3"><span class="badge rounded-pill text-bg-light border"><?= count($pizzas) ?> pizza(s)</span></div>
                <div class="table-responsive table-wrap">
                    <table class="table table-hover">
                        <thead><tr><th>ID</th><th>Sabor</th><th>Ingredientes</th><th>Tamanho</th><th>Preço</th><th>Personalizada</th></tr></thead>
                        <tbody>
                        <?php foreach ($pizzas as $pizza): ?>
                            <tr>
                                <td class="text-secondary">#<?= (int) $pizza['id_pizza'] ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($pizza['sabor'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="small"><?= htmlspecialchars($pizza['ingredientes'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><span class="badge text-bg-light border"><?= htmlspecialchars($pizza['tamanho'], ENT_QUOTES, 'UTF-8') ?></span></td>
                                <td class="fw-bold text-nowrap">R$ <?= number_format((float) $pizza['preco'], 2, ',', '.') ?></td>
                                <td><?= $pizza['personalizada'] ? '<span class="badge text-bg-success">Sim</span>' : '<span class="text-secondary">Não</span>' ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($pizzas)): ?><tr><td colspan="6" class="empty-state">Nenhuma pizza cadastrada. Use o formulário para adicionar a primeira.</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    <footer class="page-footer">Pizzaria do BernaShow · Cardápio</footer>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
