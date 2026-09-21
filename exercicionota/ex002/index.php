<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RH</title>
</head>
<body>
    <form action="" method = "post">

        <label for="salario">Salário Bruto:</label>
        <input type="number" id="salario" name="salario" required>

        <label for = "descontos">Descontos:</label>
        <input type="number" id = "descontos" name = "descontos" required>

        <button type="submit">Calcular</button>

    </form>
</body>
</html>

<?php 

    if (isset($_POST["salario"], $_POST["descontos"])) {

        $salario = floatval($_POST["salario"]);
        $descontos = floatval($_POST["descontos"]);

  
        $salario_liquido = $salario - $descontos;

        echo "<h2>Resultado</h2>";

        echo "Salário bruto: R$ "
            . number_format($salario, 2, ',', '.') 
            . "<br>";

        echo "Descontos: R$ "
            . number_format($descontos, 2, ',', '.') 
            . "<br>";

        echo "Salário líquido: R$ "
            . number_format($salario_liquido, 2, ',', '.') 
            . "<br>";

        if ($salario > 0) {

            $percentual = ($descontos / $salario) * 100;

            echo "Percentual de desconto: "
                . number_format($percentual, 2, ',', '.') 
                . "%";

        } else {

            echo "Não é possível calcular o percentual com salário igual a zero.";
        }
    }

    ?>

