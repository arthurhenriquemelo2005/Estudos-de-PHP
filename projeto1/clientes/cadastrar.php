<?php

session_start();

require "../conexao/conexao.php";


if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php"); 
    exit;
}

// Se não for POST, volta para o formulário 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastro.php");
    exit;
}

// Captura dos dados
$nome = $_POST['nome'];
$cpf_cnpj = $_POST['cpf_cnpj'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$telefone_secundario = $_POST['telefone_secundario'];
$logradouro = $_POST['logradouro'];
$numero = $_POST['numero'];
$bairro = $_POST['bairro'];
$cidade = $_POST['cidade'];
$estado = $_POST['estado'];
$cep = $_POST['cep'];


$sql = "INSERT INTO clientes (nome, cpf_cnpj, email, telefone, telefone_secundario, logradouro, numero, bairro, cidade, estado, cep)
        VALUES (:nome, :cpf_cnpj, :email, :telefone, :telefone_secundario, :logradouro, :numero, :bairro, :cidade, :estado, :cep)";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "nome" => $nome,
    "cpf_cnpj" => $cpf_cnpj,
    "email" => $email,
    "telefone" => $telefone,
    "telefone_secundario" => $telefone_secundario,
    "logradouro" => $logradouro,
    "numero" => $numero,
    "bairro" => $bairro,
    "cidade" => $cidade,
    "estado" => $estado,
    "cep" => $cep
]);

header("Location: index.php");
exit;