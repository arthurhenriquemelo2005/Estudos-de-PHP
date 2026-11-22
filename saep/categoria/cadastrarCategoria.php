<?php 
require_once(__DIR__ . '/../conexao.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: telaCategoria.php");
    exit;
}   

$categoria = trim($_POST['id_categoria'] ?? '');
$descricao = trim($_POST['descricao'] ?? '');

if (empty($categoria)) {
    header("Location: telaCategoria.php");
    exit;
}

$sql = "INSERT INTO categorias (nome, descricao) VALUES (:nome, :descricao)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":nome" => $categoria,
    ":descricao" => $descricao
]);

header("Location: telaCategoria.php");
exit;
