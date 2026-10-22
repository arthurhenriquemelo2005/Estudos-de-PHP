
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
$busca = trim($_GET['busca'] ?? '');

// Cadastrar cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $endereco = trim($_POST['endereco'] ?? '');
    $cpf = preg_replace('/\D/', '', $_POST['cpf'] ?? '');

    if (
        $nome === '' ||
        strlen($cpf) !== 11 ||
        $telefone === '' ||
        $endereco === '' ||
        mb_strlen($nome) > 100 ||
        mb_strlen($telefone) > 20 ||
        mb_strlen($endereco) > 200
    ) {
        $mensagem = 'Preencha os dados corretamente. Confira o CPF com 11 dígitos.';
    } else {
        // Aplicar hash SHA-256 ao CPF.
        $cpfHash = hash('sha256', $cpf);

        // Verificar se o CPF já está cadastrado.
        $sql = "SELECT id_cliente
                FROM clientes
                WHERE cpf_hash = :cpf_hash";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cpf_hash' => $cpfHash]);

        if ($stmt->fetch()) {
            $mensagem = 'Este CPF já está cadastrado.';
        } else {
            $sql = "INSERT INTO clientes
                    (nome, telefone, cpf_hash, endereco)
                    VALUES
                    (:nome, :telefone, :cpf_hash, :endereco)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nome' => $nome,
                ':telefone' => $telefone,
                ':cpf_hash' => $cpfHash,
                ':endereco' => $endereco
            ]);

            header("Location: clientes.php?sucesso=1");
            exit;
        }
    }
}

if (isset($_GET['sucesso'])) {
    $mensagem = 'Cliente cadastrado com sucesso!';
}

if (isset($_GET['atualizado'])) {
    $mensagem = 'Cliente atualizado com sucesso!';
}

// Buscar clientes
if ($busca !== '') {
    $sql = "SELECT id_cliente, nome, telefone, endereco
            FROM clientes
            WHERE nome LIKE :nome
               OR telefone LIKE :telefone
               OR endereco LIKE :endereco";

    $parametros = [
        ':nome' => "%$busca%",
        ':telefone' => "%$busca%",
        ':endereco' => "%$busca%"
    ];

    // Hash só permite comparação exata do CPF original.
    $cpfBusca = preg_replace('/\D/', '', $busca);

    if (strlen($cpfBusca) === 11) {
        $sql .= " OR cpf_hash = :cpf_hash";
        $parametros[':cpf_hash'] = hash('sha256', $cpfBusca);
    }

    $sql .= " ORDER BY nome";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($parametros);
    $clientes = $stmt->fetchAll();
} else {
    $sql = "SELECT id_cliente, nome, telefone, endereco
            FROM clientes
            ORDER BY nome";

    $clientes = $pdo->query($sql)->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | Pizzaria do BernaShow</title>
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
    <header class="page-heading">
        <div><h1 class="mb-2">Área de clientes</h1><p>Cadastre novos clientes e encontre cadastros existentes.</p></div>
        <a href="painel.php" class="btn btn-outline-secondary">← Voltar ao painel</a>
    </header>

    <?php if ($mensagem !== ''): ?>
        <div class="alert <?= (isset($_GET['sucesso']) || isset($_GET['atualizado'])) ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="row g-4 align-items-start">
        <div class="col-lg-4">
            <section class="content-card">
                <div class="card-heading"><span class="card-icon">＋</span><div><h2 class="mb-1">Cadastrar cliente</h2><p class="text-secondary small mb-0">Preencha os dados abaixo.</p></div></div>
                <form action="clientes.php" method="POST" class="d-grid gap-3">
                    <div><label for="nome" class="form-label">Nome completo</label><input type="text" class="form-control" id="nome" name="nome" maxlength="100" placeholder="Ex.: Maria da Silva" required></div>
                    <div><label for="telefone" class="form-label">Telefone</label><input type="text" class="form-control" id="telefone" name="telefone" maxlength="20" placeholder="(00) 00000-0000" required></div>
                    <div><label for="cpf" class="form-label">CPF</label><input type="text" class="form-control" id="cpf" name="cpf" placeholder="Somente os 11 dígitos" maxlength="14" inputmode="numeric" required><div class="form-text">O CPF é armazenado em forma de hash.</div></div>
                    <div><label for="endereco" class="form-label">Endereço</label><input type="text" class="form-control" id="endereco" name="endereco" maxlength="200" placeholder="Rua, número e bairro" required></div>
                    <button type="submit" class="btn btn-primary">Cadastrar cliente</button>
                </form>
            </section>
        </div>
        <div class="col-lg-8">
            <section class="content-card">
                <div class="card-heading"><span class="card-icon">⌕</span><div><h2 class="mb-1">Clientes cadastrados</h2><p class="text-secondary small mb-0">Pesquise por nome, telefone, endereço ou CPF completo.</p></div></div>
                <form action="clientes.php" method="GET" class="row g-2 mb-4">
                    <div class="col-sm"><label for="busca" class="visually-hidden">Pesquisar clientes</label><input type="search" class="form-control" id="busca" name="busca" value="<?= htmlspecialchars($busca, ENT_QUOTES, 'UTF-8') ?>" placeholder="Digite um termo para pesquisar"></div>
                    <div class="col-sm-auto d-flex gap-2"><button type="submit" class="btn btn-primary">Buscar</button><a href="clientes.php" class="btn btn-outline-secondary">Limpar</a></div>
                </form>
                <div class="d-flex align-items-center justify-content-between mb-3"><span class="text-secondary small">Resultados encontrados</span><span class="badge rounded-pill text-bg-light border"><?= count($clientes) ?> cliente(s)</span></div>
                <div class="table-responsive table-wrap">
                    <table class="table table-hover">
                        <thead><tr><th>ID</th><th>Nome</th><th>Telefone</th><th>Endereço</th><th>Ação</th></tr></thead>
                        <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td class="text-secondary">#<?= (int) $cliente['id_cliente'] ?></td>
                                <td class="fw-semibold"><?= htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($cliente['telefone'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($cliente['endereco'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><a class="btn btn-sm btn-outline-primary" href="editarCliente.php?id=<?= (int) $cliente['id_cliente'] ?>">Editar</a></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($clientes)): ?><tr><td colspan="5" class="empty-state">Nenhum cliente encontrado. Tente outra busca ou cadastre um cliente.</td></tr><?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    <footer class="page-footer">Pizzaria do BernaShow · Área de clientes</footer>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
