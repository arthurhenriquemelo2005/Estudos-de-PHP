<?php

session_start();
require "../conexao/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location:login.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Técnico</title>
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
            max-width: 900px;
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

        .form-select {
            appearance: none;
            background-image: linear-gradient(45deg, transparent 50%, #2563eb 50%),
                linear-gradient(135deg, #2563eb 50%, transparent 50%);
            background-position: calc(100% - 20px) calc(1.2em + 2px), calc(100% - 14px) calc(1.2em + 2px);
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
            padding-right: 2.75rem;
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
                <h1 class="h3 mb-0 fw-bold">Cadastrar Técnico</h1>
            </div>

            <div class="card-body">
                <form action="salvar.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">CPF</label>
                        <input type="text" class="form-control" name="cpf" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" name="telefone">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Especialidade</label>
                        <select class="form-select" name="especialidade" required>
                            <option value="">Selecione</option>
                            <option value="HARDWARE">Hardware</option>
                            <option value="SOFTWARE">Software</option>
                            <option value="REDES">Redes</option>
                            <option value="SUPORTE_TECNICO">Suporte Técnico</option>
                            <option value="BANCO_DE_DADOS">Banco de Dados</option>
                            <option value="SEGURANCA">Segurança</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Nível</label>
                        <select class="form-select" name="nivel">
                            <option value="">Selecione</option>
                            <option value="JUNIOR">Júnior</option>
                            <option value="PLENO">Pleno</option>
                            <option value="SENIOR">Sênior</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" required>
                            <option value="ATIVO">Ativo</option>
                            <option value="INATIVO">Inativo</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Data de Admissão</label>
                        <input type="date" class="form-control" name="data_admissao">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observação</label>
                        <textarea class="form-control" name="observacao"></textarea>
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