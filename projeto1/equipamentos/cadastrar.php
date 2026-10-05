<?php

session_start();

require "../conexao/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastro.php");
    exit;
}

$cliente = $_POST['id_cliente'];
$tipo = $_POST['tipo'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$numero_serie = $_POST['numero_serie'];
$patrimonio = $_POST['patrimonio'];
$descricao = $_POST['descricao'];
$sistema_operacional = $_POST['sistema_operacional'];
$senha_acesso = $_POST['senha_acesso'];
$status = $_POST['status'];

$sql = "INSERT INTO equipamentos (
    id_cliente,
    tipo,
    marca,
    modelo,
    numero_serie,
    patrimonio,
    descricao,
    sistema_operacional,
    senha_acesso,
    status
) VALUES (
    :id_cliente,
    :tipo,
    :marca,
    :modelo,
    :numero_serie,
    :patrimonio,
    :descricao,
    :sistema_operacional,
    :senha_acesso,
    :status
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id_cliente" => $cliente,
    ":tipo" => $tipo,
    ":marca" => $marca,
    ":modelo" => $modelo,
    ":numero_serie" => $numero_serie,
    ":patrimonio" => $patrimonio,
    ":descricao" => $descricao,
    ":sistema_operacional" => $sistema_operacional,
    ":senha_acesso" => $senha_acesso,
    ":status" => $status
]);

header("Location: index.php");
exit;