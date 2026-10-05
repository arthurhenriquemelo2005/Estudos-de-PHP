<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SESSION['perfil'] !== 'ADMIN') {
    header("Location: ../clientes/index.php");
    exit;
}

require "../conexao/conexao.php";

$sql = "SELECT id, nome, email, telefone, perfil, status FROM usuarios ORDER BY nome";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .wrapper {
            padding: 48px 18px;
        }

        .card {
            border: 0;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.96);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.10);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 20px 24px;
        }

        .table thead th {
            background: #eff6ff;
            color: #1e3a8a;
            font-weight: 700;
            border-bottom: 0;
        }

        .badge {
            font-size: 0.72rem;
            padding: 0.5rem 0.7rem;
            border-radius: 999px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 fw-bold">Usuários</h1>
                <a href="../login/painel.php" class="btn btn-light fw-semibold">Voltar ao painel</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Perfil</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= htmlspecialchars($usuario['id']) ?></td>
                                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                                    <td><?= htmlspecialchars($usuario['telefone']) ?></td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary-emphasis">
                                            <?= htmlspecialchars($usuario['perfil']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success-emphasis">
                                            <?= htmlspecialchars($usuario['status']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
