<?php 

    require "conexao.php";

    $cidade = $_POST['cidade'];

    $sql = "UPDATE alunos 
            SET cidade = :cidade";


$stmt  = $pdo ->prepare($sql);

$stmt -> execute([
    ":cidade" => $cidade
]);

    header("Location: index.html");
    exit;
?>