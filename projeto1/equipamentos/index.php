<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require "../conexao/conexao.php";

$sql = "SELECT equipamentos.*, clientes.nome AS cliente_nome
        FROM equipamentos
        INNER JOIN clientes
        ON equipamentos.id_cliente = clientes.id";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$equipamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos</title>
    <style>
        :root{
            --bg-start:#f8fafc;
            --bg-end:#dbeafe;
            --primary-start:#2563eb;
            --primary-end:#1d4ed8;
            --card-bg:rgba(255,255,255,0.98);
            --text:#0f172a;
            --muted:#6b7280;
            --radius:12px;
            --table-border:#eef2f7;
        }

        *{box-sizing:border-box}
        body{font-family: "Segoe UI", Tahoma, Arial, sans-serif; background:linear-gradient(135deg,var(--bg-start),var(--bg-end)); margin:0; padding:28px; color:var(--text)}
        .container{max-width:1100px; margin:0 auto}

        .card{background:var(--card-bg); border-radius:var(--radius); overflow:hidden; box-shadow:0 24px 60px rgba(15,23,42,0.08)}
        .card-header{display:flex; align-items:center; justify-content:space-between; padding:18px 22px; background:linear-gradient(135deg,var(--primary-start),var(--primary-end)); color:#fff}
        .card-header h1{font-size:1.1rem; margin:0}
        .card-body{padding:18px 22px}

        .btn{display:inline-block; padding:8px 12px; border-radius:10px; font-weight:700; text-decoration:none; cursor:pointer}
        .btn-primary{background: linear-gradient(135deg,var(--primary-start),var(--primary-end)); color:#fff; border:0}
        .btn-primary:hover{filter:brightness(.98)}
        .btn-secondary{background:#f3f4f6; color:var(--text); border:1px solid rgba(0,0,0,0.04)}
        .btn-excluir{background:#ef4444; color:#fff; border:0}
        .small{padding:6px 10px; font-size:0.85rem; border-radius:8px}

        .table-wrap{overflow:auto; border-radius:8px}
        table{width:100%; border-collapse:collapse; min-width:780px}
        thead th{background:#eff6ff; color:#1e3a8a; font-weight:700; text-align:left; padding:12px}
        tbody td{padding:12px; border-top:1px solid var(--table-border); vertical-align:middle}
        tbody tr:hover{background:#fbfdff}

        @media (max-width:780px){
            .card-body{padding:12px}
            thead{display:none}
            table, tbody, tr, td{display:block; width:100%}
            tr{margin-bottom:12px; background:var(--card-bg); border-radius:8px; box-shadow:0 6px 18px rgba(2,6,23,0.03)}
            td{padding:10px}
            td::before{content:attr(data-label); display:block; font-weight:700; color:var(--muted); margin-bottom:6px}
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Equipamentos</h1>
                <a href="cadastrar.php" class="btn btn-primary">Novo equipamento</a>
            </div>

            <div class="card-body">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Número de Série</th>
                                <th>Patrimônio</th>
                                <th>Sistema Operacional</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($equipamentos as $equipamento): ?>
                                <tr>
                                    <td data-label="ID"><?= htmlspecialchars($equipamento['id_equipamento'] ?? $equipamento['id']) ?></td>
                                    <td data-label="Cliente"><?= htmlspecialchars($equipamento['cliente_nome']) ?></td>
                                    <td data-label="Tipo"><?= htmlspecialchars($equipamento['tipo']) ?></td>
                                    <td data-label="Marca"><?= htmlspecialchars($equipamento['marca']) ?></td>
                                    <td data-label="Modelo"><?= htmlspecialchars($equipamento['modelo']) ?></td>
                                    <td data-label="Número de Série"><?= htmlspecialchars($equipamento['numero_serie']) ?></td>
                                    <td data-label="Patrimônio"><?= htmlspecialchars($equipamento['patrimonio']) ?></td>
                                    <td data-label="Sistema Operacional"><?= htmlspecialchars($equipamento['sistema_operacional']) ?></td>
                                    <td data-label="Status"><?= htmlspecialchars($equipamento['status']) ?></td>
                                    <td data-label="Ações">
                                        <div style="display:flex;gap:8px">
                                            <a href="editar.php?id=<?= htmlspecialchars($equipamento['id_equipamento'] ?? $equipamento['id']) ?>" class="btn btn-primary small">Editar</a>
                                            <form action="deletar.php" method="post" onsubmit="return confirm('Confirma exclusão deste equipamento?')" style="display:inline">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($equipamento['id_equipamento'] ?? $equipamento['id']) ?>">
                                                <button type="submit" class="btn btn-excluir small">Excluir</button>
                                            </form>
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

</body>
</html>