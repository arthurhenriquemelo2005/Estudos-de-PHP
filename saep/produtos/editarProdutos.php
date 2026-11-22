<?php

require_once(__DIR__ . '/../conexao.php');

    $id = filter_input(INPUT_GET, 'id_produto', FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM produtos WHERE id_produto = :id_produto";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute([
        ":id_produto" => $id
    ]);

    $produtos = $stmt ->fetch();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
</head>

<body>
    <form action="atualizarProduto.php" method="POST">

        <h1>Cadastrar Produtos</h1>

        <label for="nome">Nome do produto</label>
        <input type="text" name="nome" id="nome" placeholder="Informe o nome do produto" value="<?= htmlspecialchars($produtos['nome']) ?>" required>

        <br><br>

        <label for="descricao">Descrição</label>
        <br><br>
        <textarea name="descricao" id="descricao" placeholder="Descrição do produto"></textarea>

        <br><br>

        <label for="preco">Preço</label>
        <input type="number" name="preco" id="preco" placeholder="R$ 00,00" required>

        <br><br>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" id="preco" placeholder="Quantidade de produto" required>

        <br><br>

        <label for="id_categoria">Categoria:</label>
        <select name="id_categoria" required>
            <option value="">Selecione uma categoria</option>
            <option value="2">Periféricos</option>
            <option value="4">Móveis</option>
            <option value="5">Informática</option>
        </select>

        </select>

        <br><br>

        <button type="submit">Editar produto</button>

    </form>

</body>

</html>