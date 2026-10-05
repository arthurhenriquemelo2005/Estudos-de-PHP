<?php 

    session_start();

    require "../conexao/conexao.php";

    if(!isset($_SESSION['usuario_id'])){
        header("Location: ../login/login.php");
        exit;
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
    <title>Cadastrar Ordem de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            margin: 0 auto;
            max-width: 1100px;
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
            transition: 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.18);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #1e293b;
            border: none;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
            color: #0f172a;
        }
    </style>

</head>

<body>
    <div class="container form-wrapper">
        <div class="card">
            <div class="card-header">
                <h1 class="h3 mb-0 fw-bold">Cadastrar Ordem de Serviço</h1>
            </div>

            <div class="card-body">
                <form action="cadastrar.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Número da OS</label>
                        <input type="text" class="form-control" name="numero_os" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cliente</label>
                        <select class="form-select" name="id_cliente" required>
                            <option value="">Selecione o cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?= $cliente['id'] ?>"><?= htmlspecialchars($cliente['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Equipamento</label>
                        <select class="form-select" name="id_equipamento" required>
                            <option value="">Selecione o equipamento</option>
                            <?php foreach ($equipamentos as $equipamento): ?>
                                <option value="<?= $equipamento['id_equipamento'] ?>"><?= htmlspecialchars($equipamento['cliente_nome'] . ' - ' . $equipamento['tipo'] . ' ' . $equipamento['marca'] . ' ' . $equipamento['modelo']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Técnico</label>
                        <select class="form-select" name="id_tecnico" required>
                            <option value="">Selecione o técnico</option>
                            <?php foreach ($tecnicos as $tecnico): ?>
                                <option value="<?= $tecnico['id_tecnico'] ?>"><?= htmlspecialchars($tecnico['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Problema relatado</label>
                        <textarea class="form-control" name="problema_relatado" required></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Diagnóstico</label>
                        <textarea class="form-control" name="diagnostico"></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Serviço realizado</label>
                        <textarea class="form-control" name="servico_realizado"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="ABERTA">Aberta</option>
                            <option value="EM_ANALISE">Em análise</option>
                            <option value="EM_EXECUCAO">Em execução</option>
                            <option value="AGUARDANDO_APROVACAO">Aguardando aprovação</option>
                            <option value="AGUARDANDO_PECA">Aguardando peça</option>
                            <option value="CONCLUIDA">Concluída</option>
                            <option value="CANCELADA">Cancelada</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prioridade</label>
                        <select class="form-select" name="prioridade" required>
                            <option value="BAIXA">Baixa</option>
                            <option value="MEDIA" selected>Média</option>
                            <option value="ALTA">Alta</option>
                            <option value="URGENTE">Urgente</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Valor estimado</label>
                        <input type="number" class="form-control" name="valor_estimado" step="0.01" min="0" value="0.00">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Valor final</label>
                        <input type="number" class="form-control" name="valor_final" step="0.01" min="0" value="0.00">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Forma de pagamento</label>
                        <select class="form-select" name="forma_pagamento">
                            <option value="">Selecione</option>
                            <option value="DINHEIRO">Dinheiro</option>
                            <option value="PIX">PIX</option>
                            <option value="CARTAO">Cartão</option>
                            <option value="BOLETO">Boleto</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observações</label>
                        <textarea class="form-control" name="observacoes"></textarea>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                        <a href="index.php" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>