<!DOCTYPE html>
<html lang="pt-br ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
    $preco = $_GET["preco"];

    echo "O preço do produto é R$ $preco";  
    
    $preco = $preco +($preco*10/100);
    echo "<br>";
    echo "O preço com os 10% de juros fica por $preco ";
    ?>
</body>
</html>