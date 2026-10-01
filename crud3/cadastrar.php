<?php 

    require "conexao.php";

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: cadastro.php");
        exit;

    }
    
    $nome = trim($_POST['nome'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $senha = trim($_POST['senha'] ?? "");
    $confirmarSenha = trim($_POST['confirmarSenha'] ?? "");

    if(empty($nome) || empty($email) || empty($senha) || empty($confirmarSenha)){

        die("Todos os campos devem ser preenchidos");
   
    }

    if($senha !== $confirmarSenha){
        
        die("As senhas digitadas precisam ser a mesma. <a href= 'cadastro.php'>Tentar Novamente</a> ");
    }

    $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";

    $stmt = $pdo -> prepare($sql);

    $stmt -> execute([

        ":email" => $email

    ]);

    if($stmt -> fetch()){

        die("Este email já está cadastrado. <a href= 'cadastro.php'>Usar outro Email</a>");

    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO usuarios (nome,email,senha) 
    VALUES(:nome,:email,:senha)";

    $stmt = $pdo -> prepare($sql);
    
    $sucesso = $stmt -> execute([

        ":nome" => $nome,
        ":email" => $email,
        ":senha" => $senhaHash
    ]);

    if($sucesso){
        echo "<h2>Cadastro Realizado com sucesso</h2>";
        echo "<a href= 'login.php'>Clique aqui para fazer login</a>";
    }else{
        
        echo "Erro ao cadastrar o usuário";

    }

?>