<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Categoria</title>
</head>

<body>

    <form action="cadastrarCategoria.php" method="POST">

        <h1>Cadastre Categoria</h1>

        <label for="categoria">Informe a categoria do produto</label>
        <br>
        <select name="id_categoria" id="categoria" required>
            <option value="">Selecione uma categoria</option>
            <option value="Informática">Informática</option>
            <option value="Periféricos">Periféricos</option>
            <option value="Eletrônicos">Eletrônicos</option>
            <option value="Móveis">Móveis</option>
            <option value="Eletrodomésticos">Eletrodomésticos</option>
            <option value="Material de Escritório">Material de Escritório</option>
            <option value="Ferramentas">Ferramentas</option>
            <option value="Acessórios">Acessórios</option>
            <option value="Telefonia">Telefonia</option>
            <option value="Utensílios Domésticos">Utensílios Domésticos</option>
        </select>

        <br><br>

        <label for="descricao">Deixe uma descrição</label>
        <br>
        <textarea name="descricao" id="descricao" placeholder="Deixe uma descrição (Não é obrigatório)"></textarea>

        <br><br>
        <input type="submit" value="Cadastrar">

    </form>
    
    <br><br><br>
    <a href="verCategorias.php">Ver todas as categorias</a>

</body>

</html>
