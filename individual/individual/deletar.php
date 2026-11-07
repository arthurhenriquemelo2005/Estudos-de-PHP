<?php 

    //Chamando a conexão com o banco de dados
    require_once 'conexao.php';
    
    //Caso o metódo enviado seja diferente do Post ele volta para a tela de ver os produtos
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: verProdutos.php");
        exit;
    }
    
    //Faz a tentativa de deletar o produto
    try{
    
   //Pega o id e válida
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    //Se não existir o id volta para a tela de ver os produtos
    if(!$id){
        
        header("Location: verProdutos.php");
        exit;
    }

    //Criando o comando SQL
    $sql = "DELETE FROM produtos WHERE id = :id";
    //Preparando o comando SQL
    $stmt = $pdo ->prepare($sql);
    //Executando o comando SQL
    $stmt ->execute([
        
    ':id' => $id
    
    ]);

    //Fazendo o tratamento de erro
    }catch(PDOException $e){
        
        error_log($e ->getMessage());
    
    }

    //Redirecionando o usário para a tela de ver os produtos   
    header("Location: verProdutos.php");
    exit;
?>