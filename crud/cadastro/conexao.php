<?php 

$servidor = "localhost";
$nome = "root";
$senha = "admin";
$banco = "usuarios";

$conexao = new mysqli($servidor, $nome, $senha, $banco);

    if($conexao -> connect_error){
        die("Erro na conexão: " .$conexao -> connect_error);
    }

    

?>