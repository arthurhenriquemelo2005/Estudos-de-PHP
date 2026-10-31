<?php 

    require_once 'conexao.php';
    
    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location:cadastrar.php");
        exit;
    }

?>