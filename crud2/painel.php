<?php 

require "conexao.php";

$sql = "SELECT * FROM alunos 
ORDER BY id DESC";

$stmt = $pdo ->prepare($sql);

$stmt -> execute();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Principal</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef5ff, #ebfff7);
            min-height: 100vh;
            padding: 40px 20px;
            color: #1f2937;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 22px;
            box-shadow: 0 16px 32px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .topo {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        h1 {
            margin: 0;
            font-size: 2rem;
            color: #1f2937;
        }

        .btn-novo {
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-weight: 700;
            transition: transform 0.2s ease;
        }

        .btn-novo:hover {
            transform: translateY(-1px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 16px;
        }

        th, td {
            padding: 15px 16px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: #ffffff;
            font-size: 0.82rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        td {
            color: #374151;
            font-size: 1rem;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        tbody tr:hover {
            background: #eef6ff;
        }

        .acoes {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .acao {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            transition: opacity 0.2s ease;
        }

        .acao:hover {
            opacity: 0.9;
        }

        .editar {
            background: #e0f2fe;
            color: #0f172a;
        }

        .excluir {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topo">
            <h1>Lista com os dados dos alunos</h1>
            <a class="btn-novo" href="index.html">Cadastrar aluno</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Cidade</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($alunos = $stmt -> fetch(PDO::FETCH_ASSOC)):?>
                    <tr>
                        <td><?= htmlspecialchars($alunos['id']) ?></td>
                        <td><?= htmlspecialchars($alunos['nome']) ?></td>
                        <td><?= htmlspecialchars($alunos['email']) ?></td>
                        <td><?= htmlspecialchars($alunos['cidade']) ?></td>

                        <td>
                            <div class="acoes">
                                <a class="acao editar" href="editar.php?id=<?= $alunos['id'] ?>">Atualizar</a>
                                <a class="acao excluir" href="deletar.php?id=<?= $alunos['id'] ?>">Excluir</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>