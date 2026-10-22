<?php 

    session_start();
    require_once "conexao.php";
    
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: login.php");
        exit;
    }
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if($email === '' || $senha === ''){
        $_SESSION['erro_login'] = 'Preencha todos os campos';
        header("Location: login.php");
        exit;
    }
    
    $sql = "SELECT * FROM usuarios
            WHERE email = :email
            LIMIT 1
            ";

    $stmt = $pdo ->prepare($sql);
    $stmt -> execute([

        ":email" => $email
    ]);

    $usuario = $stmt ->fetch();

    if($email && password_verify($senha, $usuario['senha'])){
        session_regenerate_id(true);
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['perfil'] = $usuario['perfil'];

        header("Location: painel.php");
        exit;   
    }

    
    $_SESSION['erro_login'] = 'Email ou senha inválidos';
    header("Location:login.php");

?>