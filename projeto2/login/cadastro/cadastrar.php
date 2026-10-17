<?php 

    session_start();
    require_once __DIR__ . '/../../conexao/conexao.php';

   

   $nome = $_POST['nome'];
   $email = $_POST['email'];
   $senha = $_POST['senha'];
   $confirmarSenha = $_POST['confirmar_senha'];
   $perfil = 'ADMIN';


   $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

   try{
   $sql = "INSERT INTO usuario (nome,email,senha_hash,perfil,ativo,data_cadastro)
   VALUES(:nome,:email,:senha_hash,:perfil,1,CURRENT_TIMESTAMP)";   

   $stmt = $pdo -> prepare($sql);

   $stmt -> execute([

        ":nome" => $nome,
        ":email"=> $email,
        ":senha_hash" => $senhaHash,
        ":perfil" => $perfil
   ]);
    echo "Administrador criado com sucesso";
    
    } catch(PDOException $e){

        echo "<pre>";
    echo "Erro ao cadastrar administrador:\n";
    echo htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    echo "</pre>";
    }




?>