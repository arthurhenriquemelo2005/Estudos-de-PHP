<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require "../conexao/conexao.php";

$sql = "SELECT * FROM clientes ";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .clientes-wrapper {
            padding: 48px 18px;
        }

        .card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.10);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.96);
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: 0;
            padding: 20px 24px;
        }

        .card-header .btn-light {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.7rem 1rem;
        }

        .table-responsive {
            border-radius: 0 0 22px 22px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #eff6ff;
            color: #1e3a8a;
            font-weight: 700;
            border-bottom: 0;
            padding: 16px 14px;
            letter-spacing: 0.02em;
        }

        .table tbody td {
            padding: 16px 14px;
            border-color: #edf2f7;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background: #f8fbff;
        }

        .status-badge {
            display: inline-block;
            padding: 0.45rem 0.7rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: #dcfce7;
            color: #166534;
        }

        .acoes {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-editar,
        .btn-excluir {
            border-radius: 10px;
            padding: 0.45rem 0.8rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .btn-editar {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-editar:hover {
            background: #bfdbfe;
            color: #1e3a8a;
        }

        .btn-excluir {
            background: #fee2e2;
            color: #b91c1c;
        }

        .btn-excluir:hover {
            background: #fecaca;
            color: #991b1b;
        }
    </style>
</head>

<body>
    <div class="container clientes-wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 fw-bold">Clientes</h1>
                <a href="cadastrar.php" class="btn btn-light fw-semibold">Novo cliente</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>CPF/CNPJ</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $cliente): ?>
                                <tr>
                                    <td><?= htmlspecialchars($cliente['id']) ?></td>
                                    <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                    <td><?= htmlspecialchars($cliente['cpf_cnpj']) ?></td>
                                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                                    <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between gap-3">
                                            <span class="status-badge"><?= htmlspecialchars($cliente['status']) ?></span>

                                            <div class="acoes">
                                                <a href="editar.php?id=<?= $cliente['id'] ?>" class="btn-editar">Editar</a>
                                                <form action="deletar.php" method="post" style="display:inline; margin:0;">
                                                    <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']) ?>">
                                                    <button type="submit" class="btn-excluir" onclick="return confirm('Confirma exclusão deste cliente?')">Excluir</button>
                                                </form>
                                            </div>
                                        </div>
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