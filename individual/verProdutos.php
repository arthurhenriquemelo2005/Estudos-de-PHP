<?php
//Chamando conexão do banco
require_once 'conexao.php';

//Comando para fazer a busca no banco de dados
$sql = "SELECT * FROM produtos";
$stmt = $pdo->prepare($sql);
$stmt->execute();

//Comando que faz a varredura pela tabela
$produtos = $stmt->fetchAll();
$total = count($produtos); //Comando que faz a contagem dos produtos

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

    <main class="container pagina-produtos">

        <section class="painel">

            <header class="painel__topo">
                <div class="painel__titulo">
                    <h1>Produtos Cadastrados</h1>
                    <p>Veja todos os itens do seu catálogo em um só lugar.</p>
                </div>
                <span class="painel__contador"><?= $total ?> <?= $total === 1 ? 'item' : 'itens' ?></span>
            </header>

            <div class="tabela-container">
                <table class="table table-hover tabela-produtos mb-0">

                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th class="col-numero">Preço</th>
                            <th class="col-quantidade">Quantidade</th>
                            <th>Categoria</th>
                            <th class="col-acoes">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <!--Faz validação se tem algo em produtos-->
                        <?php if ($total === 0): ?>
                            <tr class="linha-vazia">
                                <td colspan="5">
                                    Nenhum produto cadastrado ainda.
                                    <a href="cadastro.php">Cadastrar o primeiro produto</a>
                                </td>
                            </tr>
                        <?php endif; ?>
                            
                        <!--Exibi os Produtos na tela-->
                        <?php foreach ($produtos as $produto): ?>
                            <tr>
                                <td class="col-nome"><?= htmlspecialchars($produto['nome']) ?></td>
                                <td class="col-numero">R$ <?= htmlspecialchars($produto['preco']) ?></td>
                                <td class="col-quantidade"><?= htmlspecialchars($produto['quantidade']) ?></td>
                                <td><span class="selo-categoria"><?= htmlspecialchars($produto['categoria']) ?></span></td>
                                <td class="col-acoes">
                                    <div class="grupo-acoes">
                                        <a href="editar.php?id=<?= (int) $produto['id'] ?>" class="btn-editar">Editar</a>

                                        <form action="deletar.php" method="POST" class="form-deletar">
                                            <input type="hidden" name="id" value="<?= (int) $produto['id'] ?>">
                                            <button type="submit" class="btn-deletar" onclick="return confirm('Deseja realmente excluir este produto?')">Deletar</button>
                                        </form> 
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>

            <footer class="acoes">
                <a href="cadastro.php" class="btn-voltar">
                    &larr; Voltar para cadastro
                </a>
            </footer>

        </section>

    </main>

</body>
</html>