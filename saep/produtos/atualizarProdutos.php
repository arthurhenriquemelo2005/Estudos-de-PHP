
<?php

require_once(__DIR__ . '/../conexao.php');

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$preco = $_POST['preco'];
$quantidade = $_POST['quantidade'];
$categoria = $_POST['id_categoria'];

$id = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);

$sql = "UPDATE produtos SET
        nome = :nome,
        descricao = :descricao,
        preco = :preco,
        quantidade = :quantidade,
        id_categoria = :id_categoria
        WHERE id_produto = :id_produto";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":nome" => $nome,
    ":descricao" => $descricao,
    ":preco" => $preco,
    ":quantidade" => $quantidade,
    ":id_categoria" => $categoria,
    ":id_produto" => $id
]);

header("Location: verProdutos.php");
exit;

?>
