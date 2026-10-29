<?php
require_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Produtos</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style.css">

</head>
<body>

    <main class="cartao-produto">

        <header class="cartao-produto__topo">
            <h1>Cadastrar Produtos</h1>
            <p>Preencha os dados abaixo para adicionar um produto.</p>
        </header>

        <form action="cadastrarProduto.php" method="POST" class="cartao-produto__corpo">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do Produto" required>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="preco" class="form-label">Preço do Produto</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="text" class="form-control" name="preco" id="preco" inputmode="numeric" placeholder="0,00" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="quantidade" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" name="quantidade" id="quantidade" inputmode="numeric" min="1" placeholder="Exemplo: 1" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="categorias" class="form-label">Categoria</label>

                <select class="form-select" name="categorias" id="categorias">

                    <option value="eletronico">Eletrônico</option>
                    <option value="periferico">Periférico</option>
                    <option value="informatica">Informática</option>
                    <option value="vestuario">Vestuário</option>
                    <option value="alimento">Alimentos</option>
                    <option value="bebida">Bebidas</option>
                    <option value="limpeza">Limpeza</option>
                    <option value="casa e decoração">Casa e Decoração</option>
                    <option value="papelaria">Papelaria</option>
                    <option value="outros">Outros</option>

                </select>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-cadastrar">Cadastrar Produto</button>
                <a href="verProdutos.php" class="btn btn-voltar">Ver produtos cadastrados</a>
            </div>
        </form>

    </main>

</body>
</html>