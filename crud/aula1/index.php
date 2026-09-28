<?php
$valor_total = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $quantidade = (int) $_POST['quantidade'];
        $preco_unitario = (float) $_POST['preco_unitario'];

        $valor_total = $quantidade * $preco_unitario;
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Calculadora de Estoque - Versão Iniciante</title>
</head>
<body>
    <h1>Calculadora de Valor de Estoque</h1>

    <form method="post">
        Nome do produto: <input type="text" name="nome"><br><br>
        Quantidade: <input type="number" name="quantidade"><br><br>
        Preço unitário: <input type="text" name="preco_unitario"><br><br>
        <input type="submit" value="Calcular">
    </form>

    <?php if ($valor_total !== null): ?>
        <h2>Resultado</h2>
        <?php
            echo "Produto " . $nome . " - Valor total: R$ " . number_format($valor_total, 2, ',', '.');
        ?>

        <h3>Var dump do valor total (tipo):</h3>
        <pre><?php var_dump($valor_total); ?></pre>
    <?php endif; ?>

</body>
</html>