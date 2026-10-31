<?php 

    //Chamando a conexao com o banco de dados
    require_once 'conexao.php';
    
    //Verificação se o enviou foi no metódo POST caso não seja vai 
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location:cadastrar.php");
        exit;
    }

    //Fazendo a tentativa da atualização do produto
    try{

    //Pegando os dados do editar
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome = $_POST['nome'];
    $preco =  str_replace(',', '.', $_POST['preco']);
    $quantidade = $_POST['quantidade'];
    $categoria = $_POST['categoria'];

    //Comando sql para a atualização do produto
    $sql = "UPDATE produtos 
            SET nome = :nome,
                preco = :preco,
                quantidade = :quantidade,
                categoria = :categoria
                WHERE id = :id";

    //Preparando o sql  
    $stmt = $pdo -> prepare($sql);

    //Executando o sql
    $stmt -> execute([

        ":nome" => $nome,
        ":preco" => $preco,
        ":quantidade" => $quantidade,
        ":categoria" => $categoria,
        ":id" => $id  

        ]);

        //Tratamento de erro caso não for realizado a tentativa
        } catch(PDOException $e){
            error_log($e -> getMessage());
        }

        //Volta para a tela de ver os produtos
        header("Location: verProdutos.php");
        exit;
?>