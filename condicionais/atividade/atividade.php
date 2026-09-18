<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media</title>
</head>
<body>
    <h1 style="color: red;">Media escolar</h1>

    <form action="atividade.php" method="get">
    <label for="nota1">Primeira nota: </label>
    <input type="number" name="nota1" placeholder="Primeira nota" required>

    <br>
    <br>
    
    <label for="nota2">Segunda nota:</label>
    <input type="number" name="nota2" placeholder="Segunda nota">
    <br>

    <input type="submit"> 
    </form>

    <?php 

   
    if(isset($_GET["nota1"],$_GET["nota2"])){
    
    $nota1 = $_GET["nota1"];
    $nota2 = $_GET["nota2"];
    $media = ($_GET["nota1"] + $_GET["nota2"]) / 2;
    
    if($media >= 7 and $media <= 10){

    echo "<p>A media entre $nota1 e $nota2 é igual a $media</p>";
    echo "<p>Situação do aluno: Aprovado</p>";

    } elseif($media >= 5 and $media < 7  ){

    echo "<p>A media entre $nota1 e $nota2 é igual a $media</p>";
    echo "<p>A situação do aluno: Recuperação</p>";
    } else{

    echo "<p>A media entre $nota1 e $nota2 é igual a $media</p>";
    echo "<p>A situação do aluno: Reprovado</p>";

    }
    
        }


   
    ?>
</body>
</html>