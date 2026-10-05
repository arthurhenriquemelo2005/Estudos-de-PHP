<?php

session_start();
require "../conexao/conexao.php";


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastro.php");
    exit;
}

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$especialidade = $_POST['especialidade'];
$nivel = $_POST['nivel'];
$data_admissao = $_POST['data_admissao'];
$status = $_POST['status'];
$observacao = $_POST['observacao'];

$sql = "INSERT INTO tecnicos (
    nome,
    cpf,
    email,
    telefone,
    especialidade,
    nivel,
    data_admissao,
    status,
    observacao
) VALUES (
    :nome,
    :cpf,
    :email,
    :telefone,
    :especialidade,
    :nivel,
    :data_admissao,
    :status,
    :observacao
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":nome" => $nome,
    ":cpf" => $cpf,
    ":email" => $email,
    ":telefone" => $telefone,
    ":especialidade" => $especialidade,
    ":nivel" => $nivel,
    ":data_admissao" => $data_admissao,
    ":status" => $status,
    ":observacao" => $observacao
]);

header("Location: index.php");
exit;
