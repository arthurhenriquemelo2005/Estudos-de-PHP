<?php 

    //Fazendo conexão com o banco de dados
    
    $servidor = 'localhost';
    $nome = 'produto';
    $usuario = 'root';
    $senha = '';

    //Tentativa de conexão  
    try{
        
        $pdo = new PDO(
            "mysql:host=$servidor;dbname=$nome;charset=utf8mb4",
            $usuario,
            $senha
        );

        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
        
        //Tratamento de erro
        }catch(PDOException $e) {
            echo "Erro na conexão" .$e -> getMessage();
        }
    

?>
