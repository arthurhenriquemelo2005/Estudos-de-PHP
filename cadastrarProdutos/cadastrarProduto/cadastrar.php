<?php


require __DIR__ . '/../conexao/conexao.php';

$nome = $_POST['nome'] ?? '';
$preco = $_POST['preco'] ?? '';
$quantidade = $_POST['quantidade'] ?? '';
$categoria = $_POST['categoria'] ?? '';

if ($nome === '' || $preco === '' || $quantidade === '' || $categoria === '') {
    header('Location: ../telaCadastro/cadastro.php');
    exit;
}

$sql =
 "INSERT INTO produtos (nome, preco, quantidade, categoria) VALUES (:nome, :preco, :quantidade, :categoria)";
$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':nome' => $nome,
    ':preco' => $preco,
    ':quantidade' => $quantidade,
    ':categoria' => $categoria
]);



header('Location: ../produtosCadastrados/index.php');
exit;
?>