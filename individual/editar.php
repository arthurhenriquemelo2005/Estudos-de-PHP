<?php

//Chamando a conexão com o banco de dados
require_once 'conexao.php';

//Pegando o id do get 
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

//Validção de se o id existe, caso não exista vai para a tela de cadastrar produtos
if (!$id) {
    header("Location: cadastro.php");
    exit;
}

//Criando a variável para consulta no banco de dados
$sql = "SELECT * FROM produtos WHERE id = :id";

//preparando a consulta 
$stmt = $pdo->prepare($sql);

//Executando a consulta
$stmt->execute([':id' => $id]);

//Guarda a consulta na váriavel produto
$produto = $stmt->fetch();

//Se caso não exisitir o produto volta para tela de cadastro
if (!$produto) {
    header("Location: cadastro.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos | Editar Produtos</title>
    <link rel="stylesheet" href="style3.css">
</head>

<body>
    <form action="atualizarProduto" method="POST">

        <h1>Editar Produto</h1>

        <label for="nome">Nome do produto</label>
        <input type="text" name="nome" id="nome" placeholder="Nome do produto" required>

        <label for="preco">Preço do Produto</label>
        <input type="text" name="preco" id="preco" inputmode="numeric" placeholder="R$0,00" required>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" id="quantidade" inputmode="numeric" placeholder="Exemplo: 1" required>

        <label for="categoria">Categoria</label>

        <select name="categorias" id="categorias">

            <option value="eletronico">Eletrônico</option>
            <option value="periferico">Periférico</option>
            <option value="informatica">Informática</option>
            <option value="vestuario">Vestuário</option>
            <option value="alimentos">Alimento</option>
            <option value="bebidas">Bebida</option>
            <option value="limpeza">Limpeza</option>
            <option value="casa e decoração">Casa de Decoração</option>
            <option value="papelaria">Papelaria</option>
            <option value="outros">Outros</option>

        </select>
        <button type="submit">Atualizar Produto</button>
        <a href="verProdutos.php">Voltar</a>

    </form>
</body>

</html>