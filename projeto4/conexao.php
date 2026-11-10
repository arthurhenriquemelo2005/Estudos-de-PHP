<?php 

    $servidor = 'localhost';
    $nome = 'db_doceecanto';
    $usuario = 'root';
    $senha = 'admin';


    try{

        $pdo = new PDO (
            "mysql:host=$servidor;dbname=$nome;charset=utf8mb4",
            $usuario,
            $senha
        );

        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    } catch (PDOException $e){
        echo "Erro de conexão" .$e ->getMessage();
    }

    

?>