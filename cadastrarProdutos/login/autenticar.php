<?php 

    session_start();
    require_once '../conexao/conexao.php';

    

   $email = trim($_POST['email'] ?? '');
   $senha = $_POST['senha'] ?? '';


   $sql = "SELECT id,nome,senha,email FROM usuarios
            WHERE email = :email";

    
    $stmt = $pdo -> prepare($sql);

    $stmt -> execute([
        ":email" => $email
    ]);

    $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

    if(!$usuario || !password_verify($senha, $usuario['senha'])){
        
        header("Location: login.php?erro=1");
        exit;
    }

    

    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];


    header("Location: ../cadastrarProduto/cadastrar.php?sucesso=1");
    exit;


?>