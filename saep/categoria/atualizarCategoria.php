<?php 

    require_once(__DIR__ .'/../conexao.php');

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: cadastrarCategoria.php");
        exit;
    }

    try{
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];

    $sql = "UPDATE categorias
            SET nome = :nome,
                descricao = :descricao
            
            WHERE id = :id";
    
    $stmt = $pdo ->prepare($sql);
    $stmt ->execute([

        ":id" => $id,
        ":nome" => $nome,
        ":descricao" => $descricao
    ]);

    }catch(PDOException $e){

    error_log($e ->getMessage());
    }
    header("Location: cadastrarCategoria.php");
    exit;

?>