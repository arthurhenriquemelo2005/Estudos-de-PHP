<?php

require_once 'conexao.php';

$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$produtos = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produtos | Cadastrados</title>

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="style2.css">
</head>
<body>

    <main class="container py-4">

        <h1>Produtos Cadastrados</h1>

        <div class="tabela-container">
            <table class="table tabela-produtos mb-0">

                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Categoria</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td>R$ <?= htmlspecialchars($produto['preco']) ?></td>
                            <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                            <td><?= htmlspecialchars($produto['categoria']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>

        <div class="acoes">
            <a href="cadastro.php" class="btn-voltar">
                &larr; Voltar para cadastro
            </a>
        </div>

    </main>

</body>
</html>