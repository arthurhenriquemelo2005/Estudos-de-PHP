<?php 

$servidor = 'localhost';
$banco = 'produto';
$usuario = 'root';
$senha = 'admin';

try{
    $pdo = new  PDO("mysql:host=$servidor;dbname=$banco;charset=utf8mb4",$usuario,$senha);

    $pdo -> setAttribute(
        PDO:: ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    $pdo -> setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );


} catch (PDOException $erro){

    die(
        "erro de comunicação de dados:" .$erro -> getMessage()
    );
}

   

?>
