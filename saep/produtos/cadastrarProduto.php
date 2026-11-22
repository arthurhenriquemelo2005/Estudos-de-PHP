<?php 

    require_once (__DIR__.'/../conexao.php');

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: telaProduto.php");
        exit;
    }

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $id_categoria = $_POST['id_categoria'];


    $sql = "INSERT INTO produtos (nome,descricao,preco,quantidade,id_categoria)
    VALUES(:nome,:descricao,:preco,:quantidade,:id_categoria)";

    $stmt = $pdo ->prepare($sql);
    $stmt -> execute([

        ":nome" => $nome,
        ":descricao" => $descricao,
        ":preco" => $preco,
        ":quantidade" => $quantidade,
        ":id_categoria" => $id_categoria
    ]);

    header("Location: verProdutos;php");
    exit;


?>