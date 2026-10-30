<?php 
    //Buscando a conexão com o banco de dados
    require_once 'conexao.php';

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: cadastro.php");
        exit;
    }
   //Tentativa de enviar o formulário para o banco 
   try {
    
    //Pegando os dados do formulário
    $nome =  $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categorias'];

    //Comando sql para inserir o produto lá no banco de dados
    $sql = "INSERT INTO produtos (nome,preco,quantidade,categoria)
            VALUES (:nome,:preco,:quantidade,:categoria)";

    //Preparando o comando sql
    $stmt = $pdo ->prepare($sql);

        //Executando o comando sql 
    $stmt->execute([
        ":nome" => $nome,
        ":preco" => $preco,
        ":quantidade" => $quantidade,
        ":categoria" => $categoria
    ]);

   

    //tratamento de erro
    } catch (PDOException $e) {
        //Caso a tentativa de cadastrar o produto der erro Mostra a mensgem de erro 
        error_log($e ->getMessage());
    }

    //Direciona para a tela do formulário
    header("Location: cadastro.php ");  