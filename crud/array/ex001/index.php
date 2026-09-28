<?php 

    $frutasEscolhidas = array("Banana", "Maçã", "Morango", "Uva", "Laranja");

    $frutas = array(
       array ("nome" => "Banana", "preco" => 10.50),
         array ("nome" => "Maçã", "preco" => 3.50),
          array ("nome" => "Morango", "preco" => 5.40),
           array ("nome" => "Uva", "preco" => 2.80),
            array ("nome" => "Laranja", "preco" => 4.20)
        );

        $totalCompra = 0;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>array</title>
</head>
<body>

    <h1>Frutas</h1>
    <h2>Essas são as frutas que estão no seu carrinho</h2>
    <h3>Essas são as frutas que você escolheu</h3>
    <ul>
            <?php foreach ($frutasEscolhidas as $escholheu): ?>
            <li><?= $escholheu ?></li>
            <?php endforeach;?>
           
        </ul>
    <h4>Preços</h4>
    <ul>
        <?php foreach ($frutas as $fruta): ?>
    
        <li><?= $fruta["nome"] ?> R$<?= number_format($fruta["preco"], 2, ',', '.') ?></li>

        


    <?php 

    $totalCompra += $fruta ["preco"];
    ?>
     <?php endforeach; ?>

     <?php  
     echo "<h4>Total da compra: R$" . number_format($totalCompra, 2, ',', '.') . "</h4>";
     ?>
     
    </ul>
</body>
</html>