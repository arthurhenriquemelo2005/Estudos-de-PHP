<?php 

    session_start();
    require "conexao.php";

    if(isset($_SESSION['id_usario'])){
        header("Location:painel.php");
        exit;
    }

    $erro = $_SESSION['erro_login'] ?? '';
    unset($_SESSION['erro_login']);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    

    <form action="autenticar.php" method="post">
        <h1>Login</h1>
        <label for="email">Nome:</label>
        <input type="email" name="email" id="email" placeholder="E-mail" required> 
        
        <br>
        <br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" placeholder="Informe a sua senha" required>

        <br>
        <br>

        <input type="submit" value="Entrar">
    </form>
</body>
</html>