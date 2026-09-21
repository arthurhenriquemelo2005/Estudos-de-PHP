

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dia da semana</title>
</head>
<body>
    <?php 

if(isset($_POST['dia'])) {
    $dia = $_POST['dia'];

    switch($dia){

        case "segunda";
        case "terça";
        case "quarta";
        case "quinta";
        case "sexta";
            echo "<p style='color: red'>Você tem aula hoje!</p>";
            break;
        
        default:
            echo"<p style='color: green'>Vai ficar de quebrada em casa hoje !</p>";
    }
}

?>



</body>
</html>
