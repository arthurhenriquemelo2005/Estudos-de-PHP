<?php

session_start();
require __DIR__ . '/../conexao/conexao.php';


if(!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true){
    header("Location: ../telaCadastro/cadastro.php");
    exit();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

        .btn-warning {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-color: #2563eb;
            color: #fff;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.22);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border-color: #1d4ed8;
            color: #fff;
        }

        .btn-danger {
            background: linear-gradient(135deg, #f87171, #dc2626);
            border-color: #dc2626;
            color: #fff;
            box-shadow: 0 8px 18px rgba(220, 38, 38, 0.2);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            border-color: #b91c1c;
            color: #fff;
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
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $produto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                                    <td>R$ <?= htmlspecialchars($produto['preco']) ?></td>
                                    <td><?= htmlspecialchars($produto['quantidade']) ?></td>
                                    <td><?= htmlspecialchars($produto['categoria']) ?></td>
                                    <td>
                                        <a href="../editarProduto/editar.php?id=<?= htmlspecialchars($produto['id']) ?>" class="btn btn-warning btn-sm me-2" title="Editar" aria-label="Editar">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        <a href="../deletar.php?id=<?= htmlspecialchars($produto['id']) ?>" class="btn btn-danger btn-sm" title="Excluir" aria-label="Excluir">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <div class="d-grid gap-2">
                <div class="d-grid gap-2">
                <a class="btn btn-primary w-100" href="../telaCadastro/cadastro.php">Voltar para cadastro</a>
            </div>
                <a class="btn btn-outline-secondary w-100" href="../sair.php">Sair</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>