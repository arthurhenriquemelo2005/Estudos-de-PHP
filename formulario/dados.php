<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>parte do php</title>
</head>

    <?php 
    
    $v = $_GET["v"];
    echo "O valor digitado foi: $v <br/>";

    
    $raiz = sqrt($v);

    echo "A raiz quadrada de $v é: " . number_format($raiz,2); 

    ?>

    <a href="index.html">Voltar</a>
</body>
</html>