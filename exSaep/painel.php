<?php 

    session_start();
    require_once "conexao.php";

    if(!isset($_SESSION['id_usuario'])){
        header("Location:login.php");
        exit;
    }

    function e($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel | Locadora </title>
</head>
<body>

    <h1>Painel da Locadora</h1>
    <p> Olá <?= e($_SESSION['nome']) ?> <p>
    <ul>

        <li><a href="clientes.php">Área dos Clientes</a></li>
        <li><a href="filme.php">Área dos Filmes</a></li>
        <li><a href="emprestimos.php">Área dos Emprestimos</a></li>
      
    </ul>
    
    <form action="sair.php" method="POST">
    <button type="submit">Sair da conta</button>
</form>


</body>
</html>

