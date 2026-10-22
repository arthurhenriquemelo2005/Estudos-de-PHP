
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

$idCliente = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$idCliente) {
    header("Location: clientes.php");
    exit;
}

$sql = "SELECT id_cliente, nome, telefone, endereco
        FROM clientes
        WHERE id_cliente = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $idCliente]);

$cliente = $stmt->fetch();

if (!$cliente) {
    exit("Cliente não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar cliente | Pizzaria do BernaShow</title>
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
                    <li class="nav-item"><a class="nav-link active" href="clientes.php">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link " href="pizzas.php">Cardápio</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link " href="pedidos.php">Pedidos</a></li>
                <li class="nav-item ms-lg-2"><a class="btn btn-outline-primary btn-sm px-3" href="sair.php">Sair</a></li>
            </ul>
        </div>
    </div>
</nav>
<main class="container page-container py-4 py-lg-5">
    <div class="page-heading"><div><h1 class="mb-2">Editar cliente <span class="text-secondary">#<?= (int) $cliente['id_cliente'] ?></span></h1><p>Atualize os dados e salve as alterações.</p></div><a href="clientes.php" class="btn btn-outline-secondary">← Voltar aos clientes</a></div>
    <div class="row justify-content-center"><div class="col-lg-8 col-xl-7">
        <section class="content-card">
            <div class="card-heading"><span class="card-icon">✎</span><div><h2 class="mb-1">Dados do cliente</h2><p class="text-secondary small mb-0">Os campos marcados são obrigatórios.</p></div></div>
            <form action="atualizarCliente.php" method="POST" class="d-grid gap-3">
                <input type="hidden" name="id_cliente" value="<?= (int) $cliente['id_cliente'] ?>">
                <div><label for="nome" class="form-label">Nome completo</label><input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8') ?>" maxlength="100" required></div>
                <div><label for="telefone" class="form-label">Telefone</label><input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone'], ENT_QUOTES, 'UTF-8') ?>" maxlength="20" required></div>
                <div><label for="endereco" class="form-label">Endereço</label><input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco'], ENT_QUOTES, 'UTF-8') ?>" maxlength="200" required></div>
                <div><label for="cpf" class="form-label">Novo CPF <span class="text-secondary fw-normal">(opcional)</span></label><input type="text" class="form-control" id="cpf" name="cpf" maxlength="14" placeholder="Deixe em branco para manter o CPF atual"><div class="form-text">O CPF atual não pode ser recuperado, pois está armazenado como hash.</div></div>
                <div class="d-flex flex-wrap gap-2 pt-2"><button type="submit" class="btn btn-primary">Salvar alterações</button><a href="clientes.php" class="btn btn-outline-secondary">Cancelar</a></div>
            </form>
        </section>
    </div></div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
