<?php 

    //Chamando a conexao com o banco de dados
    require_once 'conexao.php';
    
    //Verificação se o enviou foi no metódo POST caso não seja vai redirecionar para a tela de cadastrar
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location:cadastrar.php");
        exit;
    }

?>