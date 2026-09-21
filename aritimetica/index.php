<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>php matemática</title>
</head>
<body>
    <h1>Aula de aritmetica</h1>
    <?php 
    
    $n1 = $_GET["a"];
    $n2 = $_GET["b"];
    $soma = $n1 + $n2;

    echo "<h2> Valores recebidos $n1 e $n2 </h2>";

    echo "<h3>A soma entre $n1 e $n2 é de $soma</h3>"; 

    
     
    ?>
</body>
</html>