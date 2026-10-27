<?php 

    //Fazendo conexão com o banco de dados
    
    $servidor = 'localhost';
    $nome = 'produto';
    $usuario = 'root';
    $senha = 'XXX';

    try{
        
        $pdo = new PDO(
            "mysql:host=$servidor;dbname=$nome;charset=utf8mb4",
            $usuario,
            $senha
        );

        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        
    
        }catch(PDOException $e) {
            echo "Erro na conexão" .$e -> getMessage();
        }
    

?>