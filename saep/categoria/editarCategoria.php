<?php 

    require_once(__DIR__ .'/../conexao.php');
    
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $sql = "SELECT * FROM categorias WHERE id = :id";

    $stmt = $pdo -> prepare($sql);

    $stmt -> execute([
        ':id' => $id
    ]);

    $categoria = $stmt ->fetch();
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoria</title>
</head>
<body>


    <form action="atualizarCategoria.php" method="POST">

        <h1>Edite Categoria</h1>

        <input type="hidden" name="id" value="<?= (int) $categoria['id'] ?>"> 
        
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($categoria['nome'])?>" placeholder="Informe nome da categoria" required>

        <br><br>

        <p>Deixe uma descirção</p>
        <textarea name="descricao" id="descricao" placeholder="Deixe uma descrição (Não é obrigatorio)"><?= htmlspecialchars($categoria['descricao']) ?></textarea>
        
        <br><br>
        <input type="submit" value="Editar Categoria">
        
        
    </form>
    <br><br><br>
    <a href="verCategorias.php">Ver todas as categorias</a>
</body>
</html>