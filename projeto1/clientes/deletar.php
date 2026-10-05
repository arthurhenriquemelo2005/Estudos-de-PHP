<?php 

session_start();
require "../conexao/conexao.php";

if(!isset($_SESSION['usuario_id'])){
    header("Location: ../login/login.php");
    exit;
}

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: index.php");
    exit;
}

if (!isset($_POST['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_POST['id'];

$sql = "DELETE FROM clientes WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

header("Location: index.php");
exit;


?>