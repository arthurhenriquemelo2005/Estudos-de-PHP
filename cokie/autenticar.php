<?php 

    session_start();

        $usario = $_POST['usuario'];
        $senha = $_POST['senha'];

        if($usario === "admin" && $senha === "1234"){
        $_SESSION["usuario"] = $usario;
        header("Location: painel.php");
        exit;
        } else{
            echo "Usuario não encontrado";
        }
    
        

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
</head>
<body>
    <a href="index.php">Inicio</a>
</body>
</html>