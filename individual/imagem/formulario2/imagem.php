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