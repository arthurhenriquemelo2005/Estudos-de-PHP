<?php 

include "conexao.php";

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$idade = $_POST['idade'];
$curso = $_POST['curso'];


$sql = "UPDATE alunos 
        SET nome = :nome,
            email = :email,
            idade = :idade,
            curso = :curso
        WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":nome" => $nome,
    ":email" => $email,
    ":idade" => $idade,
    ":curso" => $curso,
    ":id" => $id
]);

header("Location: index.php");
exit;
?>