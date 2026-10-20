<?php

session_start();

require_once __DIR__ . '/../../conexao/conexao.php';
require_once __DIR__ . '/buscar.php';
function e($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$totalAgendamentos = count($agendamentos);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendamentos | EcoPoint</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css?v=1">
</head>

<body>

    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">E</div>
            <span>EcoPoint</span>
        </div>

        <div class="user-area">
            <a href="../../painel/painel.php" class="btn-painel">
                Voltar ao painel
            </a>

            <a href="../../painel/logout.php" class="btn-sair">
                Sair
            </a>
        </div>
    </header>

    <main class="page-content">

        <div class="page-heading">
            <div>
                <span class="eyebrow">GERENCIAMENTO</span>

                <h1>Agendamentos</h1>

                <p>
                    Consulte e gerencie as solicitações de coleta.
                </p>

                <p>
                    <?= $totalAgendamentos ?>
                    agendamento(s) encontrado(s).
                </p>
            </div>

            <a href="cadastrar.php" class="btn-eco">
                + Novo agendamento
            </a>
        </div>

        <section class="content-card">

            <div class="card-heading">
                <h2>Lista de agendamentos</h2>
            </div>

            <form method="GET" action="agendamentos.php" class="search-form">

                <div class="search-field">
                    <label for="busca">Pesquisar</label>

                    <input
                        type="text"
                        id="busca"
                        name="busca"
                        class="form-control"
                        placeholder="Nome, e-mail ou endereço"
                        value="<?= e($busca) ?>">
                </div>

                <div class="status-field">
                    <label for="status">Status</label>

                    <select
                        name="status"
                        id="status"
                        class="form-select">
                        <option value="">Todos os status</option>

                        <option value="PENDENTE"
                            <?= $status === 'PENDENTE' ? 'selected' : '' ?>>
                            Pendente
                        </option>

                        <option value="CONFIRMADO"
                            <?= $status === 'CONFIRMADO' ? 'selected' : '' ?>>
                            Confirmado
                        </option>

                        <option value="EM_ANDAMENTO"
                            <?= $status === 'EM_ANDAMENTO' ? 'selected' : '' ?>>
                            Em andamento
                        </option>

                        <option value="CONCLUIDO"
                            <?= $status === 'CONCLUIDO' ? 'selected' : '' ?>>
                            Concluído
                        </option>

                        <option value="CANCELADO"
                            <?= $status === 'CANCELADO' ? 'selected' : '' ?>>
                            Cancelado
                        </option>
                    </select>
                </div>

                <div class="search-actions">
                    <button type="submit" class="btn-eco">
                        Buscar
                    </button>

                    <a href="agendamentos.php" class="btn-limpar">
                        Limpar
                    </a>
                </div>

            </form>

            <div class="table-responsive">

                <table class="table appointments-table align-middle">

                    <thead>
                        <tr>
                            <th>Participante</th>
                            <th>Endereço da coleta</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($agendamentos)): ?>

                            <?php foreach ($agendamentos as $agendamento): ?>

                                <?php
                                $classeStatus = strtolower(
                                    str_replace(
                                        '_',
                                        '-',
                                        $agendamento['status']
                                    )
                                );

                                $dataFormatada = date(
                                    'd/m/Y',
                                    strtotime($agendamento['data_solicitada'])
                                );
                                ?>

                                <tr>

                                    <td>
                                        <div class="participant-name">
                                            <?= e($agendamento['nome_participante']) ?>
                                        </div>

                                        <div class="participant-email">
                                            <?= e($agendamento['email_participante']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?= e($agendamento['endereco_coleta']) ?>
                                    </td>

                                    <td>
                                        <?= e($dataFormatada) ?>
                                    </td>

                                    <td>
                                        <?= e($agendamento['faixa_horario']) ?>
                                    </td>

                                    <td>
                                        <span class="status-badge status-<?= e($classeStatus) ?>">
                                            <?= e(str_replace('_', ' ', $agendamento['status'])) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a
                                                href="editar.php?id=<?= (int) $agendamento['id_agendamento'] ?>"
                                                class="btn-edit">
                                                Editar
                                            </a>
                                        </div>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <h3>Nenhum agendamento encontrado</h3>

                                        <p>
                                            Tente alterar os filtros ou cadastre
                                            um novo agendamento.
                                        </p>
                                    </div>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

        <a href="../../painel/painel.php" class="back-link">
            ← Voltar ao painel
        </a>

    </main>

    <footer>
        <p>EcoPoint &copy; <?= date('Y') ?> — Sistema de gestão de coletas.</p>
    </footer>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>