<?php 

    require "conexao.php";

    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cidade = $_POST["cidade"];

    $sql = "INSERT INTO alunos (nome,email,cidade)
    VALUES(:nome,:email,:cidade)";

    $stmt = $pdo -> prepare($sql);

    $stmt -> execute(
        [
        ":nome" => $nome,
        ":email" => $email,
        ":cidade" => $cidade
    ]
    
    );

    header("Location: index.html?sucesso=1");
    exit;
?>