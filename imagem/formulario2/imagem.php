<?php 

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $nome = $_POST['nome'];
        $arquivo = $_FILES['arquivo'];
        
        $caminho = 'uploads/' .$arquivo['name'];

        move_uploaded_file($arquivo['tmp_name'], $caminho);

        echo $nome ."<br>";
        echo "<img src='$caminho' width='400'>";
    }

    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrando os cadastro</title>
</head>
<body>
    <button type="submit"><a href="index.html">Voltar</a></button>
</body>
</html>