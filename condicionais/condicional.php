<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condicional</title>
</head>

<body>
    <form action="condicional.php" method="get">

        <label for="ano">Ano nascimento:</label>
        <input type="number" name="ano" id="ano" required>

        <input type="submit" value="Enviar">
        <br>

     <?php

        if (isset($_GET["ano"])) {

            $ano = $_GET["ano"];
            $idade = date("Y") - $ano;

            

            if ($idade < 16) {

                $tipoVoto = "Não pode votar";

            } else if ($idade >= 16 && $idade < 18) {

                $tipoVoto = "Voto opcional";
            }
            else{
               
                $tipoVoto = "Voto obrigatorio";

            }
        }

        
        ?>


    </form>
</body>

</html>