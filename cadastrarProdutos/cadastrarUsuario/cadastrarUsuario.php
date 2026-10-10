<?php 

    require '../conexao/conexao.php';

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmarSenha'] ?? '';

    if($nome === '' || $email === '' || $senha === '' || $confirmarSenha === ''){
        
        die("Todos os campos devem ser preenchido");
    
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        
        die("Informe um email válido");

    }
    if($senha !== $confirmarSenha){
        
        die("As senhas devem ser iguais");

    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);



    $sql = "INSERT INTO usuarios (nome,email,senha)
            VALUES(:nome,:email,:senha)";

    
    $stmt = $pdo ->prepare($sql);

    $stmt -> execute([

        ":nome" => $nome,
        ":email" => $email,
        ":senha" => $senhaHash
    ]);

    echo "Usuario Cadastrado com sucesso";



?>