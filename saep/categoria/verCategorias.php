<?php 

    require_once(__DIR__ .'/../conexao.php');

    

    $sql = "SELECT * FROM categorias";

    $stmt = $pdo -> prepare($sql);

    $stmt -> execute();

    $categorias = $stmt ->fetchAll();
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias</title>
</head>
<body>
    
    <h1>Ver todas as Categorias</h1>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
        </tr>
        <tr>
        <?php foreach ($categorias as $categoria) :?>
         
                <td><?= htmlspecialchars($categoria['id']) ?></td> 
                <td><?= htmlspecialchars($categoria['nome']) ?></td>
                <td><?= htmlspecialchars($categoria['descricao']) ?> </td>
            
                <td><a href="editarCategoria.php?id=<?=(int) $categoria['id']?>">Editar</a>
                <form action="deletar.php" method="POST">
                 <input type="hidden" name="id" value="<?= (int) $categoria['id'] ?>">
                 <button type="submit" onclick="return confirm('Deseja realmente excluir?')">Deletar</button>
                 </td>
             </form>
            </tr>
            <?php endforeach ;?>
        </table>
        
        <a href="telaCategoria.php">Voltar para a tela de cadastro</a>
</body>
</html>