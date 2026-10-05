<?php 

    session_start();
    require "../conexao/conexao.php";

    if(!isset($_SESSION['usuario_id'])){
        header("Location: ../login/login.php");
        exit;
    }

    $sql = "SELECT
            ordens_servico.*,
            clientes.nome AS cliente_nome,
            equipamentos.tipo AS equipamento_tipo,
            equipamentos.marca AS equipamento_marca,
            equipamentos.modelo AS equipamento_modelo,
            tecnicos.nome AS tecnico_nome

        FROM ordens_servico

        INNER JOIN clientes
            ON ordens_servico.id_cliente = clientes.id

        INNER JOIN equipamentos
            ON ordens_servico.id_equipamento = equipamentos.id_equipamento

        INNER JOIN tecnicos
            ON ordens_servico.id_tecnico = tecnicos.id_tecnico

        ORDER BY ordens_servico.id_os DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $ordens = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordens de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .os-wrapper {
            padding: 48px 18px;
        }

        .card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.12);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.97);
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            border: 0;
            padding: 20px 24px;
        }

        .card-header h1 {
            margin: 0;
            font-weight: 700;
        }

        .card-header .btn-light {
            border-radius: 12px;
            font-weight: 600;
            padding: 0.7rem 1rem;
            color: #1d4ed8;
        }

        .table-responsive {
            border-radius: 0 0 22px 22px;
        }

        .table {
            margin-bottom: 0;
            min-width: 1100px;
        }

        .table thead th {
            background: #eff6ff;
            color: #1e3a8a;
            font-weight: 700;
            border-bottom: 0;
            padding: 16px 14px;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 16px 14px;
            border-color: #edf2f7;
            vertical-align: middle;
            color: #334155;
        }

        .table tbody tr:hover {
            background: #f8fbff;
        }

        .status-badge,
        .priority-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.45rem 0.75rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .status-badge {
            background: #dcfce7;
            color: #166534;
        }

        .status-badge.em-analise,
        .status-badge.em-execucao,
        .status-badge.aguardando-aprovacao,
        .status-badge.aguardando-peca {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.concluida {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .status-badge.cancelada {
            background: #fee2e2;
            color: #991b1b;
        }

        .priority-badge.baixa {
            background: #dcfce7;
            color: #166534;
        }

        .priority-badge.media {
            background: #fef3c7;
            color: #92400e;
        }

        .priority-badge.alta,
        .priority-badge.urgente {
            background: #fee2e2;
            color: #991b1b;
        }

        .acoes {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .btn-editar,
        .btn-excluir {
            border: 0;
            border-radius: 10px;
            padding: 0.5rem 0.85rem;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s ease;
            cursor: pointer;
        }

        .btn-editar {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .btn-editar:hover {
            background: #bfdbfe;
            color: #1e3a8a;
            text-decoration: none;
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
    <div class="container os-wrapper">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 fw-bold">Ordens de Serviço</h1>
                <a href="cadastro.php" class="btn btn-light fw-semibold">Nova Ordem</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nº OS</th>
                                <th>Cliente</th>
                                <th>Equipamento</th>
                                <th>Técnico</th>
                                <th>Data Abertura</th>
                                <th>Status</th>
                                <th>Prioridade</th>
                                <th>Valor Estimado</th>
                                <th>Valor Final</th>
                                <th class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordens as $ordem): ?>
                                <?php
                                    $statusClass = strtolower(str_replace('_', '-', trim((string) $ordem['status'])));
                                    $priorityClass = strtolower(trim((string) $ordem['prioridade']));
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($ordem['id_os']) ?></td>
                                    <td><?= htmlspecialchars($ordem['numero_os']) ?></td>
                                    <td><?= htmlspecialchars($ordem['cliente_nome']) ?></td>
                                    <td><?= htmlspecialchars($ordem['equipamento_tipo'] . ' ' . $ordem['equipamento_marca'] . ' ' . $ordem['equipamento_modelo']) ?></td>
                                    <td><?= htmlspecialchars($ordem['tecnico_nome']) ?></td>
                                    <td><?= htmlspecialchars($ordem['data_abertura']) ?></td>
                                    <td><span class="status-badge <?= $statusClass ?>"><?= htmlspecialchars($ordem['status']) ?></span></td>
                                    <td><span class="priority-badge <?= $priorityClass ?>"><?= htmlspecialchars($ordem['prioridade']) ?></span></td>
                                    <td>R$ <?= number_format((float) $ordem['valor_estimado'], 2, ',', '.') ?></td>
                                    <td><?= !empty($ordem['valor_final']) ? 'R$ ' . number_format((float) $ordem['valor_final'], 2, ',', '.') : '—' ?></td>
                                    <td>
                                        <div class="acoes">
                                            <a href="editar.php?id=<?= $ordem['id_os'] ?>" class="btn-editar">Editar</a>
                                            <form action="deletar.php" method="POST" style="display:inline; margin:0;" onsubmit="return confirm('Confirma a exclusão desta ordem de serviço?')">
                                                <input type="hidden" name="id" value="<?= $ordem['id_os'] ?>">
                                                <button type="submit" class="btn-excluir">Excluir</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>