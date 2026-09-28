<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja</title>
</head>
<body>
    <form action="" method="post">
        <label for="nome">Nome do produto:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="quantidade">Quantidade:</label>
        <input type="number" id="quantidade" name="quantidade" required>

        <label for="preco_unitario">Preço unitário:</label>
        <input type="text" id="preco_unitario" name="preco_unitario" required>

        <button type="submit">Calcular</button>
    </form>
</body>
</html>

<?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeProduto = (string) $_POST['nome'] ;
    $quantidade = (int) $_POST['quantidade'] ;
    $precoUnitario = (float) $_POST['preco_unitario'] ;

    $valorEstoque = (float) ($quantidade * $precoUnitario);

    echo "Produto: " . $nomeProduto . "<br>";
    echo "Quantidade: " . $quantidade . "<br>";
    echo "Preço unitário: R$ " . number_format($precoUnitario, 2, '.', ',') . "<br>"; 
    echo "Valor total do estoque: R$ " . number_format($valorEstoque, 2, '.', ',') . "<br>";

    var_dump($valorEstoque);
    }

?>