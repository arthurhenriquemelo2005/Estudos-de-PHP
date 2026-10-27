<?php
//Chamando conexao com o banco de dados
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

    <form action="cadastrarProduto.php" method="POST">

        <h1>Cadastrar Produtos</h1>

        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" placeholder="Nome do Produto" required>

        <label for="preco">Preço do Produto</label>
        <input type="text" name="preco" id="preco" inputmode="numeric" placeholder="R$0,00" required>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" inputmode="numeric" placeholder="Exemplo: 1" required>

        <label for="categoria">Categoria</label>

        <select name="categorias" id="categorias">

            <option value="eletronico">Eletrônico</option>
            <option value="periferico">Periférico</option>
            <option value="informatica">Informatica</option>
            <option value="vestuario">Vestuário</option>
            <option value="alimento">Aliementos</option>
            <option value="bebida">Bebidas</option>
            <option value="limpeza">Limpeza</option>
            <option value="casa e decoração">Casa e Decoração</option>
            <option value="papelaria">Papelaria</option>
            <option value="outros">Outros</option>

        </select>

        <input type="submit" value="Cadastrar Produto">

        <a href="verProdutos.php">Ir para tela de produtos Cadastrados</a>
    </form>

</body>
</html>