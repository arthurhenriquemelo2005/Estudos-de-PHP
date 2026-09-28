<?php
include "conexao.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do aluno não fornecido. <a href='index.php'>Voltar</a>");
}
$id = $_GET['id'];

$sql = "SELECT * FROM alunos WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    die("Aluno não encontrado");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
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
            min-height: 100vh;
        }

        h1 {  
            color: #2c3e50;  
            margin-bottom: 24px; 
            font-size: 24px; 
        }

        /* Estilizando o formulário em formato de card */
        form {  
            background-color: #ffffff;  
            padding: 30px;  
            border-radius: 8px;  
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);  
            width: 100%;  
            max-width: 450px;  
        }

        label {  
            display: block;  
            margin-bottom: 6px;  
            font-weight: 600;  
            color: #2c3e50;  
            font-size: 14px;  
        }

        /* Campos de texto, email e número */
        input[type="text"],
        input[type="email"],
        input[type="number"] {  
            width: 100%;  
            padding: 12px;  
            margin-bottom: 20px;  
            border: 1px solid #ddd;  
            border-radius: 6px;  
            font-size: 14px;  
            transition: border-color 0.2s, box-shadow 0.2s;  
        }

        /* Efeito quando clica no input */
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus {  
            border-color: #3498db;  
            outline: none;  
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.15);  
        }

        /* Botão de Salvar Alterações */
        button[type="submit"] {  
            background-color: #2ecc71;  
            color: #ffffff;  
            border: none;  
            padding: 12px 20px;  
            border-radius: 6px;  
            font-size: 15px;  
            font-weight: 600;  
            cursor: pointer;  
            width: 100%;  
            transition: background-color 0.2s, opacity 0.2s;  
        }

        button[type="submit"]:hover {  
            background-color: #27ae60;  
        }

        /* Link de Voltar */
        a {  
            display: inline-block;  
            margin-top: 20px;  
            color: #3498db;  
            text-decoration: none;  
            font-weight: 600;  
            transition: color 0.2s;  
        }

        a:hover {  
            color: #2980b9;  
            text-decoration: underline;  
        }   
    </style>
</head>
<body>
    
    <h1>Editar Aluno</h1>

    <form action="atualizar.php" method="POST">
        <!-- Corrigido o excesso de ?> -->
        <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($aluno['id']) ?>">

        <label>Nome:</label><br>
      
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($aluno['nome']) ?>"><br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($aluno['email']) ?>"><br><br>

        <label>Idade:</label><br>
        <input type="number" name="idade" id="idade" value="<?= htmlspecialchars($aluno['idade']) ?>"><br><br>

        <label>Curso:</label><br>
        <input type="text" name="curso" id="curso" value="<?= htmlspecialchars($aluno['curso']) ?>"><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="index.php">Voltar</a>

</body>
</html>