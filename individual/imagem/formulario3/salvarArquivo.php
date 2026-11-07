<?php 

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $arquivo = $_FILES['arquivo'];
        $permitidos = ['jpg', 'jpeg', 'png'];

       $extensoes = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

       if(in_array($extensoes, $permitidos)){

        $caminho = 'uploads/' .$arquivo['name'];
        move_uploaded_file($arquivo['tmp_name'], $caminho);

        echo "<img src='$caminho' width='500'>";
       
        } else{
            
        echo "Formato não permitod. Só são permitidos jpg, jpeg e png";

        }

    }

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquivos</title>
</head>
<body>
    <button><a href="index.html">Voltar</a></button>
</body>
</html>