<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['perfil'] !== 'ADMIN') {
    header("Location: painel.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e0f2fe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .panel-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .panel-card {
            width: 100%;
            max-width: 760px;
            border: 0;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .panel-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 28px 30px;
        }

        .panel-body {
            padding: 30px;
        }

        .badge-perfil {
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 0.55rem 0.85rem;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px 18px;
            margin-bottom: 18px;
        }

        .info-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #64748b;
            margin-bottom: 6px;
        }

        .admin-box {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 16px;
            padding: 20px;
            margin-top: 18px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }

        .btn-outline-danger {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
        }
    </style>
</head>

<body>
    <div class="panel-wrapper">
        <div class="panel-card">
            <div class="panel-header">
                <h1 class="mb-0 fw-bold">Painel do Sistema</h1>
            </div>

            <div class="panel-body">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                    <div>
                        <span class="info-label">Usuário</span>
                        <h3 class="mb-0"><?= htmlspecialchars($_SESSION['nome']) ?></h3>
                    </div>
                    <span class="badge-perfil"><?= htmlspecialchars($_SESSION['perfil']) ?></span>
                </div>

                <div class="info-box">
                    <span class="info-label">Status da conta</span>
                    <p class="mb-0">Sessão ativa e autorizada</p>
                </div>

                <?php if ($_SESSION['perfil'] === 'ADMIN'): ?>
                    <div class="admin-box">
                        <h4 class="mb-3">Área administrativa</h4>
                        <a href="usuarios/index.php" class="btn btn-primary">Gerenciar usuários</a>
                    </div>
                <?php endif; ?>

                <div class="mt-4 d-flex justify-content-end">
                    <a href="logout.php" class="btn btn-outline-danger">Sair</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>