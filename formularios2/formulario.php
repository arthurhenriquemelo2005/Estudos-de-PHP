<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario 2 com php</title>
</head>
<body>

    <?php 
    
    $nome = $_GET["nome"];
    $ano_nascimento = $_GET["ano_nascimento"];
    $sexo = $_GET["sexo"];
    $idade = date("Y") - $ano_nascimento;

    echo "<h3>Seu nome é $nome você nasceu em $ano_nascimento e você é $sexo e você tem $idade anos</h3>";
    

    ?>
    
</body>
</html>