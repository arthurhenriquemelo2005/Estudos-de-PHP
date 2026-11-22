<?php 

    require_once (__DIR__ .'/../conexao.php');

    $sql = "SELECT * FROM produtos";
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute();

    $produtos = $stmt ->fetchAll();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
</head>
<body>

        <h1>Produtos Cadastrados</h1>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th>Ações</th>
            </tr>

            <tr>
                <?php foreach ($produtos as $produto): ?>
                <td><?= htmlspecialchars($produto['id_produto']) ?></td>
                <td><?= htmlspecialchars($produto['nome']) ?></td>
                <td><?= htmlspecialchars($produto['descricao']) ?></td>
                <td><?= htmlspecialchars($produto['preco']) ?></td>
                <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                
                <td>
                    <a href="editarProdutos.php?id_produto=<?= (int) $produto['id_produto'] ?>">Editar</a>
                    <?php endforeach ;?>

                    <form action="deletar.php" method="POST">
                        <input type="hidden" name="id_produto" value="<?= (int) $produto['id_produto'] ?>">
                        <button onclick="return confirm('Deseja mesmo excluir?')">Deletar</button>
                    </form>
                </td>
            </tr>
        </table>
                    
</body>
</html>