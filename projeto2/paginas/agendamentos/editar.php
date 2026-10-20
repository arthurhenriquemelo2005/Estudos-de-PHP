<?php require_once __DIR__ . '/atualizarAgendamento.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar status | EcoPoint</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header class="topbar">
        <div class="brand">
            <div class="brand-mark">E</div>
            <span>EcoPoint</span>
        </div>

        <div class="user-area">
            <a href="agendamentos.php" class="btn-painel">
                Voltar aos agendamentos
            </a>

            <a href="../../painel/logout.php" class="btn-sair">
                Sair
            </a>
        </div>
    </header>

    <main class="page-content form-page">

        <div class="page-heading">
            <div>
                <span class="eyebrow">GERENCIAMENTO</span>
                <h1>Editar agendamento</h1>
                <p>Altere o status da solicitação de coleta.</p>
            </div>
        </div>

        <section class="content-card form-card">

            <div class="card-heading">
                <h2>Agendamento #<?= (int) $agendamento['id_agendamento'] ?></h2>
                <p class="text-muted mb-0 mt-2">
                    Os dados da coleta não podem ser alterados nesta tela.
                </p>
            </div>

            <div class="form-body">

                <?php if (!empty($erros)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($erros as $erro): ?>
                            <p class="mb-0"><?= e($erro) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="form-grid">

                    <div class="form-field full-width">
                        <label class="form-label">Participante</label>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= e($agendamento['nome_participante']) ?>"
                            disabled
                        >
                    </div>

                    <div class="form-field full-width">
                        <label class="form-label">Endereço da coleta</label>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= e($agendamento['endereco_coleta']) ?>"
                            disabled
                        >
                    </div>

                    <div class="form-field">
                        <label class="form-label">Data</label>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= e(date('d/m/Y', strtotime($agendamento['data_solicitada']))) ?>"
                            disabled
                        >
                    </div>

                    <div class="form-field">
                        <label class="form-label">Faixa de horário</label>
                        <input
                            type="text"
                            class="form-control"
                            value="<?= e($agendamento['faixa_horario']) ?>"
                            disabled
                        >
                    </div>

                </div>

                <form method="POST" action="editar.php" class="mt-4">

                    <input
                        type="hidden"
                        name="id_agendamento"
                        value="<?= (int) $agendamento['id_agendamento'] ?>"
                    >

                    <div class="form-field">
                        <label for="status" class="form-label">
                            Status do agendamento
                        </label>

                        <select
                            name="status"
                            id="status"
                            class="form-select"
                            required
                            <?= empty($statusDisponiveis) ? 'disabled' : '' ?>
                        >
                            <option value="">Selecione o novo status</option>

                            <?php foreach ($statusDisponiveis as $statusOpcao): ?>
                                <option value="<?= e($statusOpcao) ?>">
                                    <?= e(str_replace('_', ' ', $statusOpcao)) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-actions">

                        <a href="agendamentos.php" class="btn-limpar">
                            Voltar
                        </a>

                        <?php if (!empty($statusDisponiveis)): ?>
                            <button type="submit" class="btn-eco">
                                Salvar status
                            </button>
                        <?php else: ?>
                            <span class="text-muted">
                                Este agendamento não pode mais ser alterado.
                            </span>
                        <?php endif; ?>

                    </div>

                </form>

            </div>
        </section>

    </main>

    <footer>
        <p>EcoPoint &copy; <?= date('Y') ?> — Sistema de gestão de coletas.</p>
    </footer>

</body>
</html>