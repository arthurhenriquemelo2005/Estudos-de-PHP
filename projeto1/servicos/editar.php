<?php

session_start();

require "../conexao/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Buscar a ordem de serviço

$sql = "SELECT *
        FROM ordens_servico
        WHERE id_os = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$ordem = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ordem) {
    die("Ordem de serviço não encontrada.");
}


// Buscar clientes

$sql = "SELECT id, nome
        FROM clientes
        WHERE status = 'ATIVO'
        ORDER BY nome";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Buscar equipamentos

$sql = "SELECT
            equipamentos.id_equipamento,
            equipamentos.tipo,
            equipamentos.marca,
            equipamentos.modelo,
            clientes.nome AS cliente_nome

        FROM equipamentos

        INNER JOIN clientes
            ON equipamentos.id_cliente = clientes.id

        WHERE equipamentos.status != 'INATIVO'

        ORDER BY clientes.nome";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$equipamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Buscar técnicos

$sql = "SELECT id_tecnico, nome
        FROM tecnicos
        WHERE status = 'ATIVO'
        ORDER BY nome";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Ordem de Serviço</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .form-wrapper {
            padding: 48px 18px;
        }

        .card {
            border: 0;
            border-radius: 22px;
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.10);
            background: rgba(255, 255, 255, 0.96);
            overflow: hidden;
            max-width: 1100px;
            margin: 0 auto;
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            border: 0;
            padding: 20px 24px;
        }

        .card-body {
            padding: 28px 24px 24px;
        }

        .form-label {
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select,
        textarea.form-control {
            border: 1px solid #dbeafe;
            border-radius: 12px;
            background: #f8fbff;
            padding: 0.8rem 0.9rem;
            transition: 0.2s ease;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus,
        textarea.form-control:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 0.2rem rgba(96, 165, 250, 0.15);
            background: white;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.2rem;
            font-weight: 600;
        }

        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }

        .btn-secondary {
            background: #64748b;
            border-color: #64748b;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1d4ed8;
            margin-top: 10px;
            margin-bottom: 4px;
        }

        .section-description {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="form-wrapper">

    <div class="card">

        <div class="card-header">

            <h3 class="mb-1">
                Editar Ordem de Serviço
            </h3>

            <p class="mb-0 opacity-75">
                Atualize as informações da ordem de serviço.
            </p>

        </div>


        <div class="card-body">

            <form action="atualizar.php" method="POST">

                <input
                    type="hidden"
                    name="id_os"
                    value="<?= $ordem['id_os'] ?>"
                >


                <!-- Dados principais -->

                <div class="section-title">
                    Dados principais
                </div>

                <div class="section-description">
                    Informações básicas da ordem de serviço.
                </div>


                <div class="row g-4">


                    <!-- Número da OS -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Número da OS
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="numero_os"
                            value="<?= htmlspecialchars($ordem['numero_os']) ?>"
                            required
                        >

                    </div>


                    <!-- Cliente -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Cliente
                        </label>

                        <select
                            class="form-select"
                            name="id_cliente"
                            required
                        >

                            <?php foreach ($clientes as $cliente): ?>

                                <option
                                    value="<?= $cliente['id'] ?>"
                                    <?= $cliente['id'] == $ordem['id_cliente'] ? 'selected' : '' ?>
                                >

                                    <?= htmlspecialchars($cliente['nome']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Equipamento -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Equipamento
                        </label>

                        <select
                            class="form-select"
                            name="id_equipamento"
                            required
                        >

                            <?php foreach ($equipamentos as $equipamento): ?>

                                <option
                                    value="<?= $equipamento['id_equipamento'] ?>"
                                    <?= $equipamento['id_equipamento'] == $ordem['id_equipamento'] ? 'selected' : '' ?>
                                >

                                    <?= htmlspecialchars(
                                        $equipamento['cliente_nome']
                                        . ' - '
                                        . $equipamento['tipo']
                                        . ' '
                                        . $equipamento['marca']
                                        . ' '
                                        . $equipamento['modelo']
                                    ) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Técnico -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Técnico
                        </label>

                        <select
                            class="form-select"
                            name="id_tecnico"
                            required
                        >

                            <?php foreach ($tecnicos as $tecnico): ?>

                                <option
                                    value="<?= $tecnico['id_tecnico'] ?>"
                                    <?= $tecnico['id_tecnico'] == $ordem['id_tecnico'] ? 'selected' : '' ?>
                                >

                                    <?= htmlspecialchars($tecnico['nome']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>


                    <!-- Data de previsão -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Data de previsão
                        </label>

                       <input
                        type="datetime-local"
                        class="form-control"
                        name="data_previsao"
                        value="<?= $ordem['data_previsao'] ? date('Y-m-d\TH:i', strtotime($ordem['data_previsao'])) : '' ?>"
                    >

                    </div>


                    <!-- Status -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            class="form-select"
                            name="status"
                            required
                        >

                            <option
                                value="ABERTA"
                                <?= $ordem['status'] == 'ABERTA' ? 'selected' : '' ?>
                            >
                                Aberta
                            </option>

                            <option
                                value="EM_ANALISE"
                                <?= $ordem['status'] == 'EM_ANALISE' ? 'selected' : '' ?>
                            >
                                Em análise
                            </option>

                            <option
                                value="EM_EXECUCAO"
                                <?= $ordem['status'] == 'EM_EXECUCAO' ? 'selected' : '' ?>
                            >
                                Em execução
                            </option>

                            <option
                                value="AGUARDANDO_APROVACAO"
                                <?= $ordem['status'] == 'AGUARDANDO_APROVACAO' ? 'selected' : '' ?>
                            >
                                Aguardando aprovação
                            </option>

                            <option
                                value="AGUARDANDO_PECA"
                                <?= $ordem['status'] == 'AGUARDANDO_PECA' ? 'selected' : '' ?>
                                >
                                Aguardando peça
                            </option>

                            <option
                                value="CONCLUIDA"
                                <?= $ordem['status'] == 'CONCLUIDA' ? 'selected' : '' ?>
                            >
                                Concluída
                            </option>

                            <option
                                value="CANCELADA"
                                <?= $ordem['status'] == 'CANCELADA' ? 'selected' : '' ?>
                            >
                                Cancelada
                            </option>

                        </select>

                    </div>


                    <!-- Prioridade -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Prioridade
                        </label>

                        <select
                            class="form-select"
                            name="prioridade"
                            required
                        >

                            <option
                                value="BAIXA"
                                <?= $ordem['prioridade'] == 'BAIXA' ? 'selected' : '' ?>
                            >
                                Baixa
                            </option>

                            <option
                                value="MEDIA"
                                <?= $ordem['prioridade'] == 'MEDIA' ? 'selected' : '' ?>
                            >
                                Média
                            </option>

                            <option
                                value="ALTA"
                                <?= $ordem['prioridade'] == 'ALTA' ? 'selected' : '' ?>
                            >
                                Alta
                            </option>

                            <option
                                value="URGENTE"
                                <?= $ordem['prioridade'] == 'URGENTE' ? 'selected' : '' ?>
                            >
                                Urgente
                            </option>

                        </select>

                    </div>


                    <!-- Valor estimado -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Valor estimado
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="valor_estimado"
                            step="0.01"
                            min="0"
                            value="<?= htmlspecialchars($ordem['valor_estimado']) ?>"
                        >

                    </div>


                    <!-- Valor final -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Valor final
                        </label>

                        <input
                            type="number"
                            class="form-control"
                            name="valor_final"
                            step="0.01"
                            min="0"
                            value="<?= htmlspecialchars($ordem['valor_final']) ?>"
                        >

                    </div>


                    <!-- Forma de pagamento -->

                    <div class="col-md-6">

                        <label class="form-label">
                            Forma de pagamento
                        </label>

                        <select
                            class="form-select"
                            name="forma_pagamento"
                        >

                            <option value="">
                                Selecione
                            </option>

                            <option
                                value="DINHEIRO"
                                <?= $ordem['forma_pagamento'] == 'DINHEIRO' ? 'selected' : '' ?>
                            >
                                Dinheiro
                            </option>

                            <option
                                value="PIX"
                                <?= $ordem['forma_pagamento'] == 'PIX' ? 'selected' : '' ?>
                            >
                                PIX
                            </option>

                            <option
                                value="CARTAO"
                                <?= $ordem['forma_pagamento'] == 'CARTAO' ? 'selected' : '' ?>
                            >
                                Cartão
                            </option>

                            <option
                                value="BOLETO"
                                <?= $ordem['forma_pagamento'] == 'BOLETO' ? 'selected' : '' ?>
                            >
                                Boleto
                            </option>

                        </select>

                    </div>


                    


                    <!-- Problema relatado -->

                    <div class="col-12">

                        <label class="form-label">
                            Problema relatado
                        </label>

                        <textarea
                            class="form-control"
                            name="problema_relatado"
                            required
                        ><?= htmlspecialchars($ordem['problema_relatado']) ?></textarea>

                    </div>


                    <!-- Diagnóstico -->

                    <div class="col-12">

                        <label class="form-label">
                            Diagnóstico
                        </label>

                        <textarea
                            class="form-control"
                            name="diagnostico"
                        ><?= htmlspecialchars($ordem['diagnostico'] ?? '') ?></textarea>

                    </div>


                    <!-- Serviço realizado -->

                    <div class="col-12">

                        <label class="form-label">
                            Serviço realizado
                        </label>

                        <textarea
                            class="form-control"
                            name="servico_realizado"
                        ><?= htmlspecialchars($ordem['servico_realizado'] ?? '') ?></textarea>

                    </div>


                    <!-- Observações -->

                    <div class="col-12">

                        <label class="form-label">
                            Observações
                        </label>

                        <textarea
                            class="form-control"
                            name="observacoes"
                        ><?= htmlspecialchars($ordem['observacoes'] ?? '') ?></textarea>

                    </div>

                </div>


                <!-- Botões -->

                <div class="d-flex gap-2 mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Salvar alterações
                    </button>

                    <a
                        href="index.php"
                        class="btn btn-secondary"
                    >
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

</body>

</html>