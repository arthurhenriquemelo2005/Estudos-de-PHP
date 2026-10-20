<?php

    require_once __DIR__ . '/cadastrarAgendamento.php'; 

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Novo agendamento | EcoPoint</title>

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
            <a href="../../painel/painel.php" class="btn-painel">
                Voltar ao painel
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
                <h1>Novo agendamento</h1>
                <p>Preencha os dados para solicitar uma coleta.</p>
            </div>
        </div>

        <section class="content-card form-card">

            <div class="card-heading">
                <h2>Dados da coleta</h2>
                <p class="text-muted mb-0 mt-2">
                    Os campos marcados com * são obrigatórios.
                </p>
            </div>

            <div class="form-body">

                <?php if (!empty($erros)): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>Verifique os dados informados:</strong>

                        <ul class="mb-0 mt-2">
                            <?php foreach ($erros as $erro): ?>
                                <li><?= e($erro) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (empty($participantes)): ?>

                    <div class="alert alert-warning" role="alert">
                        Não existem participantes cadastrados.
                        Cadastre um participante antes de criar um agendamento.
                    </div>

                    <a
                        href="../participantes/participantes.php"
                        class="btn btn-outline-success"
                    >
                        Ir para participantes
                    </a>

                <?php else: ?>

                    <form method="POST" action="cadastrarAgendamento.php">

                        <div class="form-grid">

                            <div class="form-field full-width">
                                <label for="id_participante" class="form-label">
                                    Participante *
                                </label>

                                <select
                                    name="id_participante"
                                    id="id_participante"
                                    class="form-select"
                                    required
                                >
                                    <option value="">Selecione um participante</option>

                                    <?php foreach ($participantes as $participante): ?>
                                        <option
                                            value="<?= (int) $participante['id_participante'] ?>"
                                            <?= $valores['id_participante'] == $participante['id_participante'] ? 'selected' : '' ?>
                                        >
                                            <?= e($participante['nome']) ?>
                                            — <?= e($participante['email']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-field full-width">
                                <label for="endereco_coleta" class="form-label">
                                    Endereço da coleta *
                                </label>

                                <input
                                    type="text"
                                    name="endereco_coleta"
                                    id="endereco_coleta"
                                    class="form-control"
                                    maxlength="200"
                                    placeholder="Rua, número, bairro e complemento"
                                    value="<?= e($valores['endereco_coleta']) ?>"
                                    required
                                >
                            </div>

                            <div class="form-field">
                                <label for="data_solicitada" class="form-label">
                                    Data da coleta *
                                </label>

                                <input
                                    type="date"
                                    name="data_solicitada"
                                    id="data_solicitada"
                                    class="form-control"
                                    min="<?= e($hoje) ?>"
                                    value="<?= e($valores['data_solicitada']) ?>"
                                    required
                                >

                                <div class="form-text">
                                    Não são aceitas datas anteriores a hoje.
                                </div>
                            </div>

                            <div class="form-field">
                                <label for="faixa_horario" class="form-label">
                                    Faixa de horário *
                                </label>

                                <select
                                    name="faixa_horario"
                                    id="faixa_horario"
                                    class="form-select"
                                    required
                                >
                                    <option value="">Selecione um horário</option>

                                    <?php foreach ($horarios as $valor => $rotulo): ?>
                                        <option
                                            value="<?= e($valor) ?>"
                                            <?= $valores['faixa_horario'] === $valor ? 'selected' : '' ?>
                                        >
                                            <?= e($rotulo) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-field full-width">
                                <label for="observacoes" class="form-label">
                                    Observações
                                </label>

                                <textarea
                                    name="observacoes"
                                    id="observacoes"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Informações adicionais sobre a coleta (opcional)"
                                ><?= e($valores['observacoes']) ?></textarea>
                            </div>

                        </div>

                        <div class="form-actions">
                            <a href="agendamentos.php" class="btn-limpar">
                                Cancelar
                            </a>

                            <button type="submit" class="btn-eco">
                                Salvar agendamento
                            </button>
                        </div>

                    </form>

                <?php endif; ?>

            </div>

        </section>

    </main>

    <footer>
        <p>EcoPoint &copy; <?= date('Y') ?> — Sistema de gestão de coletas.</p>
    </footer>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>