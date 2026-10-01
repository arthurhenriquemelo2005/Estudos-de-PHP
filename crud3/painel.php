<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Painel</title>
</head>
<body>
    <h1>Área Restrita</h1>
    <?php echo "Bem-Vindo, "; echo htmlspecialchars($_SESSION['usuario_nome'])?>
    <ul>
        <li><?php echo htmlspecialchars($_SESSION['usuario_id'] ?? 'usuario_id') ?></li>
        <li><?php echo htmlspecialchars($_SESSION['usuario_nome'])?></li>
        <li><?php echo htmlspecialchars($_SESSION['usuario_email'])?></li>
    </ul>
    <p><a href="logout.php">Sair</a></p>
</body>
</html>