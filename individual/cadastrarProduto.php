<?php 

    require_once 'conexao.php';

   try {
    
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categorias'];

    $sql = "INSERT INTO produtos (nome,preco,quantidade,categoria)
            VALUES (:nome,:preco,:quantidade,:categoria)";

    $stmt = $pdo ->prepare($sql);

    $stmt -> execute ([
        ":nome" => $nome,
        ":preco" => $preco,
        ":quantidade" => $quantidade,
        ":categoria" => $categoria
    ]);

    echo 'Produto cadastrado';
    }catch (PDOException $e){

        echo 'Erro ao cadastrar o produto' . $e ->getMessage();
    }

    header("Location: cadastro.php ");  