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
    
</head>
<body>

    <form action="cadastrarPoduto.php"method="POST">
        
        <h1>Cadastrar Produtos</h1>

        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" placeholder="Nome do Produto" required>
        
        <label for="preco">Preço do Produto</label>
        <input type="text" name="preco" id="preco" inputmode="numeric" placeholder="R$0,00" required>

        <label for="quantidade">Quantidade</label>
        <input type="number" name="quantidade" inputmode="numeric" placeholder="Exemplo: 1" required>

        <label for="categoria">Categoria</label>
        <input type="text" name="categoria" id="categoria" placeholder="Categoria do produto">   
        
        <input type="submit" value="Cadastrar Produto">
    
    </form>

</body>
</html>