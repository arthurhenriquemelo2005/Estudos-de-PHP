<?php 

    require "conexao.php";

    if(!isset($_GET['id']) || empty($_GET['id'])){
        die("ID do aluno não foi fornecido. <a href='index.html'>Voltar</a>");
    }

    $id = $_GET['id'];

    $sql = "SELECT * FROM alunos WHERE id = :id";

    $stmt = $pdo -> prepare($sql);

    $stmt->execute([':id' => $id]);

    $aluno = $stmt -> fetch(PDO::FETCH_ASSOC);

    if(!$aluno){
        die("Aluno não encontrado");
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alunos</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #eef6ff, #effaf5);
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 520px;
            background: #ffffff;
            padding: 36px 30px;
            border-radius: 18px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
        }

        h1 {
            margin: 0 0 24px;
            text-align: center;
            color: #1f2937;
            font-size: 2rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        label {
            font-weight: 700;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .botoes {
            display: flex;
            gap: 12px;
            margin-top: 12px;
        }

        button,
        .btn-voltar {
            flex: 1;
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        button {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
        }

        .btn-voltar {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        button:hover,
        .btn-voltar:hover {
            transform: translateY(-1px);
            opacity: 0.96;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Alunos</h1>

        <form action="atualizar.php" method="post">
            <input type="hidden" name="id" id="id" value="<?= htmlspecialchars($aluno['id']) ?>">


            <label for="cidade">Cidade:</label>
            <input type="text" name="cidade" id="cidade" value="<?= htmlspecialchars($aluno["cidade"]) ?>">

            <div class="botoes">
                <button type="submit">Salvar</button>
                <a class="btn-voltar" href="index.html">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>