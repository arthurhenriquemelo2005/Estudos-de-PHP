<?php 

    require "conexao.php";

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "DELETE FROM alunos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    header("Location: painel.php");
    exit;
}

$sql = "SELECT * FROM alunos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    die("Aluno não encontrado. <a href='painel.php'>Voltar</a>");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir aluno</title>
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
            background: linear-gradient(135deg, #fff1f2, #eef2ff);
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 520px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.12);
            padding: 32px 28px;
            text-align: center;
        }

        .icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            font-weight: bold;
        }

        h1 {
            margin: 0 0 12px;
            color: #1f2937;
            font-size: 2rem;
        }

        p {
            margin: 0 0 26px;
            color: #4b5563;
            font-size: 1.05rem;
            line-height: 1.6;
        }

        .dados {
            background: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 24px;
            text-align: left;
        }

        .dados strong {
            display: block;
            color: #111827;
            margin-bottom: 4px;
        }

        .dados span {
            color: #374151;
            font-size: 1.05rem;
        }

        form {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        button,
        .btn-cancelar {
            border: none;
            border-radius: 12px;
            padding: 14px 22px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        button {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #ffffff;
        }

        .btn-cancelar {
            background: #e5e7eb;
            color: #111827;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        button:hover,
        .btn-cancelar:hover {
            transform: translateY(-1px);
            opacity: 0.96;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">!</div>
        <h1>Excluir aluno</h1>
        <p>Tem certeza que deseja excluir o aluno abaixo?</p>

        <div class="dados">
            <strong>Aluno:</strong>
            <span><?= htmlspecialchars($aluno['nome']) ?></span>
        </div>

        <form action="deletar.php?id=<?= htmlspecialchars($id) ?>" method="post">
            <button type="submit">Confirmar exclusão</button>
            <a class="btn-cancelar" href="painel.php">Cancelar</a>
        </form>
    </div>
</body>
</html>
