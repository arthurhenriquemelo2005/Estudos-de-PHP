<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_POST['id'];

require "../conexao/conexao.php";

$sql = "DELETE FROM equipamentos
        WHERE id_equipamento = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

header("Location: index.php");
exit;