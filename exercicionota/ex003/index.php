<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banco</title>
</head>
<body>
    <h1>Informe as seguintes informações</h1>
    
    <form action="" method = "post">
        <label for = "idade">Idade:</label>
        <input type="number" id = "idade" name = "idade" required>
        <br><br>
        <label for = "renda">Renda Mensal:</label>
        <input type="number" id = "renda" name = "renda" required>

        <input type="submit" value = "Enviar">
        
    </form>
</body>
</html>

<?php 

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    $idade = (int) $_POST["idade"] ;
    $renda = floatval ($_POST["renda"]) ;

    $aprovado = ($idade >18) and ($renda >= 1500);

    echo "Resultado da Análise: ";

    var_dump($aprovado);
    
    
    }
?>