<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cálculo de Preço</title>
</head>
<body>
    <form method="POST">
        <label>Custo de Fábrica (R$):</label>
        <input type="number" step="0.01" name="custo" required>
        <button type="submit">Calcular</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $custo = (float) $_POST["custo"];
        $valorFinal = ($custo + 25.00) * 2;

        echo "<p>Valor Final de Venda: R$ " . number_format($valorFinal, 2, ',', '.') . "</p>";

        echo "<pre>";
        var_dump($valorFinal);
        echo "</pre>";
    }
    ?>
</body>
</html>