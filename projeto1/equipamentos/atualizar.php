<?php

session_start();

require "../conexao/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id_equipamento = isset($_POST['id_equipamento']) ? (int) $_POST['id_equipamento'] : null;

if (!$id_equipamento) {
    header("Location: index.php");
    exit;
}

$id_cliente = isset($_POST['id_cliente']) ? (int) $_POST['id_cliente'] : null;
$tipo = trim($_POST['tipo'] ?? '');
$marca = trim($_POST['marca'] ?? '');
$modelo = trim($_POST['modelo'] ?? '');
$numero_serie = trim($_POST['numero_serie'] ?? '');
$patrimonio = trim($_POST['patrimonio'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');
$sistema_operacional = trim($_POST['sistema_operacional'] ?? '');
$senha_acesso = trim($_POST['senha_acesso'] ?? '');
$status = trim($_POST['status'] ?? '');


$sql = "UPDATE equipamentos SET

    id_cliente = :id_cliente,
    tipo = :tipo,
    marca = :marca,
    modelo = :modelo,
    numero_serie = :numero_serie,
    patrimonio = :patrimonio,
    descricao = :descricao,
    sistema_operacional = :sistema_operacional,
    senha_acesso = :senha_acesso,
    status = :status

    WHERE id_equipamento = :id_equipamento";


$stmt = $pdo->prepare($sql);


$stmt->execute([

    ":id_cliente" => $id_cliente,
    ":tipo" => $tipo,
    ":marca" => $marca,
    ":modelo" => $modelo,
    ":numero_serie" => $numero_serie,
    ":patrimonio" => $patrimonio,
    ":descricao" => $descricao,
    ":sistema_operacional" => $sistema_operacional,
    ":senha_acesso" => $senha_acesso,
    ":status" => $status,
    ":id_equipamento" => $id_equipamento

]);


header("Location: index.php");
exit;
