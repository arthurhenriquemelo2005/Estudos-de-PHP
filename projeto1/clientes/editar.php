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

$sql = "SELECT * FROM clientes WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([

    'id' => $id

]);

$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    header("Location: index.php");
    exit;
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .editar-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .editar-card {
            width: 100%;
            max-width: 900px;
            border: 0;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 24px 60px rgba(37, 99, 235, 0.12);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 22px 28px;
        }

        .card-body {
            padding: 28px;
        }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid #dbe4f0;
            padding: 0.8rem 1rem;
            background: #f8fbff;
        }

        .form-control:focus {
            border-color: rgba(37, 99, 235, 0.7);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: 0;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.25);
        }
    </style>
</head>

<body>
    <div class="editar-wrapper">
        <div class="editar-card">
            <div class="card-header">
                <h1 class="h3 mb-0 fw-bold">Editar Cliente</h1>
            </div>

            <div class="card-body">
                <form action="atualizar.php" method="POST">
                    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nome</label>
                            <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CPF/CNPJ</label>
                            <input type="text" class="form-control" name="cpf_cnpj" value="<?= htmlspecialchars($cliente['cpf_cnpj']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($cliente['email']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" class="form-control" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone secundário</label>
                            <input type="text" class="form-control" name="telefone_secundario" value="<?= htmlspecialchars($cliente['telefone_secundario']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Logradouro</label>
                            <input type="text" class="form-control" name="logradouro" value="<?= htmlspecialchars($cliente['logradouro']) ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Número</label>
                            <input type="text" class="form-control" name="numero" value="<?= htmlspecialchars($cliente['numero']) ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Bairro</label>
                            <input type="text" class="form-control" name="bairro" value="<?= htmlspecialchars($cliente['bairro']) ?>">
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input type="text" class="form-control" name="cidade" value="<?= htmlspecialchars($cliente['cidade']) ?>">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Estado</label>
                            <input type="text" class="form-control" name="estado" value="<?= htmlspecialchars($cliente['estado']) ?>">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">CEP</label>
                            <input type="text" class="form-control" name="cep" value="<?= htmlspecialchars($cliente['cep']) ?>">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>