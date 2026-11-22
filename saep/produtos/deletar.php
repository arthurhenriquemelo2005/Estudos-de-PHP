<?php 

    require_once(__DIR__ .'/../conexao.php');

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: verProdutos.php");
        exit;
    }

    $id = filter_input(INPUT_POST, 'id_produto', FILTER_VALIDATE_INT);
    $sql = "DELETE FROM produtos WHERE id_produto = :id_produto";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([
        ":id_produto" => $id
    ]);

    header("Location: verProdutos.php");
    exit;

?>