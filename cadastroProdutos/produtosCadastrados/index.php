<?php

session_start();
require __DIR__ . '/../conexao/conexao.php';

if (!isset($_SERVER['REQUEST_METHOD']) || ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'POST')) {
    header('Location: ../telaCadastro/cadastro.html');
    exit;
}

$sql = "SELECT * FROM produtos ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos Cadastrados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #eaf1ff;
            --text: #1f2937;
            --muted: #64748b;
            --shadow: 0 18px 45px rgba(37, 99, 235, 0.18);
        }

        body {
            background: radial-gradient(circle at top, rgba(255,255,255,0.9), rgba(218, 231, 255, 0.95) 35%, #dfeaff 100%);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
        }

        .card {
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            backdrop-filter: blur(8px);
        }

        h1 {
            font-weight: 700;
            letter-spacing: -0.04em;
        }

        .table thead th {
            background: linear-gradient(180deg, #edf4ff, #dfeaff);
            color: #1e3a8a;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: none;
            padding: 1rem 1.1rem;
        }

        .table tbody td {
            padding: 1rem 1.1rem;
            vertical-align: middle;
            border-color: #edf2ff;
        }

        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(234, 241, 255, 0.35);
        }

        .table-hover > tbody > tr:hover > td {
            background-color: rgba(37, 99, 235, 0.05);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-color: var(--primary-dark);
        }

        .text-primary {
            color: var(--primary-dark) !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card p-4 p-md-5 mx-auto">
            <h1 class="text-center text-primary mb-4">Produtos Cadastrados</h1>

            <?php if (empty($produtos)): ?>
                <p class="text-center text-muted fst-italic mb-0">Nenhum produto cadastrado.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-4">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Categoria</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                                    <td>R$ <?= htmlspecialchars($produto['preco']) ?></td>
                                    <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                                    <td><?= htmlspecialchars($produto['categoria']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <a class="btn btn-primary w-100" href="../telaCadastro/cadastro.html">Voltar para cadastro</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>