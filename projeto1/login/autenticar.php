<?php 

    session_start();

    include "../conexao/conexao.php";

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = :email AND STATUS = 'ATIVO'";
    
    $stmt = $pdo -> prepare($sql);

    $stmt ->execute([

    ":email" => $email
    ]);

    $usuario = $stmt ->fetch(PDO::FETCH_ASSOC);

    if(!$usuario || !password_verify($senha, $usuario['senha'])){
        $_SESSION['erro_login'] = "E-mail ou senha incorretos.";
        header("Location: login.php");
        exit;
    }

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['perfil'] = $usuario['perfil'];
    unset($_SESSION['erro_login']);

    header("Location: painel.php");
    exit;

?>