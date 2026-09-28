<?php
    include "conexao.php";

    $sql = "SELECT * FROM alunos ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista dos Alunos</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            color: #333;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        /* Ajustado para cadastro.php */
        a[href="cadastrar.php"] {
            display: inline-block;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-weight: 600;
            transition: background-color 0.3s ease;
            margin-bottom: 30px;
            box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
        }

        /* Ajustado para cadastro.php */
        a[href="cadastrar.php"]:hover {
            background-color: #2980b9;
        }

        table {
            width: 100%;
            max-width: 1000px;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #eeeeee;
        }

        th {
            background-color: #2c3e50;
            color: #ffffff;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        tr {
            transition: background-color 0.2s ease;
        }

        tr:hover td {
            background-color: #f9fbfc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        td a {
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 600;
            color: #ffffff;
            transition: opacity 0.2s;
            display: inline-block;
        }

        td a:hover {
            opacity: 0.85;
        }

        td a[href^="editar.php"] {
            background-color: #2ecc71; 
        }

        td a[href^="deletar.php"] {
            background-color: #e74c3c; 
            margin-left: 8px;
        }
    </style>
</head>
<body>
    
    <h1>Lista de Alunos</h1>

    <!-- Link apontando para cadastro.php -->
    <a href="cadastrar.php">Cadastre-se!</a>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Idade</th>
            <th>Curso</th>
            <th>Ações</th>
        </tr>
        
        <?php while ($aluno = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td>
                <?= htmlspecialchars($aluno['id']) ?>
             </td>
            <td>
                <?= htmlspecialchars($aluno['nome']) ?>
             </td>
            <td>
                <?= htmlspecialchars($aluno['email']) ?>
             </td>
            <td>
                <?= htmlspecialchars($aluno['idade']) ?>
             </td>
            <td>
                <?= htmlspecialchars($aluno['curso']) ?>
             </td>
             <td>
                <a href="editar.php?id=<?= $aluno['id'] ?>">Editar</a>
                <br><br>
                <a href="deletar.php?id=<?= $aluno['id'] ?>" onclick="return confirm('Deseja realmente excluir este aluno?');">Excluir</a>
             </td>
        </tr>
        <?php endwhile; ?>

    </table>

</body>
</html>