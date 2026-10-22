<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    header("Location: painel.php");
    exit;
}

$erro = $_SESSION['erro_login'] ?? '';
unset($_SESSION['erro_login']);

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Pizzaria do BernaShow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="assets/css/pizzaria.css" rel="stylesheet">
</head>
<body class="login-page min-vh-100">
<main class="login-card">
    <div class="login-logo" aria-hidden="true">🍕</div>
    <p class="text-uppercase small fw-bold text-danger mb-2">Sistema de atendimento</p>
    <h1 class="login-title mb-2">Pizzaria do BernaShow</h1>
    <p class="text-secondary mb-4">Entre com suas credenciais para acessar o sistema.</p>

    <?php if ($erro !== ''): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <form action="autenticacao.php" method="POST" class="d-grid gap-3">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">
        <div>
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="seuemail@exemplo.com" autocomplete="username" required autofocus>
        </div>
        <div>
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" autocomplete="current-password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-lg mt-2">Entrar no sistema</button>
    </form>
    <p class="text-secondary small text-center mt-4 mb-0">Acesso restrito a usuários cadastrados.</p>
</main>
</body>
</html>
