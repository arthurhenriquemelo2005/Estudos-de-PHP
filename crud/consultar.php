<?php

require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastrar.php");
    exit;
}
$nome = trim($_POST['nome']);
$email = trim($_POST['email']);
$idade = $_POST['idade'];
$curso = trim($_POST['curso']);

if (
    $nome === "" ||
    $email === "" ||
    $idade === "" ||
    $curso === ""
) {
    die("Todos os campos são obrigatorios");
}

$sql = "INSERT INTO alunos (nome, email, idade, curso)
                VALUES(:nome, :email, :idade, :curso)";

$smst = $pdo->prepare($sql);

$smst->execute(

    [
        ":nome" => $nome,
        ":email" => $email,
        ":idade" => $idade,
        ":curso" => $curso
    ]

);

echo "Seus dados foram enviados !";
