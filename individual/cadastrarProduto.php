<?php 
    //Buscando a conexão com o banco de dados
    require_once 'conexao.php';

   //Tentativa de enviar o formulário para o banco 
   try {
    
    //Pegando os dados do formulário
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categorias'];

    //Comando sql para inserir o produto lá no banco de dados
    $sql = "INSERT INTO produtos (nome,preco,quantidade,categoria)
            VALUES (:nome,:preco,:quantidade,:categoria)";

    //Preparando o comando sql
    $stmt = $pdo ->prepare($sql);

    //Executando o comando sql 
    $stmt -> execute ([
        ":nome" => $nome,
        ":preco" => $preco,
        ":quantidade" => $quantidade,
        ":categoria" => $categoria
    ]);

    //Caso tentativa tenha dado certo mostra ao usuário A mensagem de produto cadastrado
    echo 'Produto cadastrado';

    //tratamento de erro
    } catch (PDOException $e) {
        //Caso a tentativa de cadastrar o produto der erro Mostra a mensgem de erro 
        echo 'Erro ao cadastrar o produto' . $e ->getMessage();
    }

    //Direciona para a tela do formulário
    header("Location: cadastro.php ");  