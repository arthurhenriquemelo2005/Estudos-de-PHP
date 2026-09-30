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