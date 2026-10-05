<?php

session_start();
require "../conexao/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];


// Buscar o equipamento

$sql = "SELECT *
        FROM equipamentos
        WHERE id_equipamento = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":id" => $id
]);

$equipamento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$equipamento) {
    die("Equipamento não encontrado.");
}


// Buscar os clientes ativos

$sql = "SELECT id, nome
        FROM clientes
        WHERE status = 'ATIVO'
        ORDER BY nome";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Equipamento</title>

    <style>
        :root{
            --bg-start: #f8fafc;
            --bg-end: #dbeafe;
            --card-header-start: #2563eb;
            --card-header-end: #1d4ed8;
            --card-bg: rgba(255,255,255,0.98);
            --text: #0f172a;
            --muted: #6b7280;
            --radius: 12px;
        }

        *{box-sizing:border-box}
        body{font-family: "Segoe UI", Tahoma, Arial, sans-serif; background:linear-gradient(135deg,var(--bg-start),var(--bg-end)); margin:0; padding:28px; color:var(--text)}
        .container{max-width:900px; margin:0 auto}
        .card{background:var(--card-bg); border-radius:var(--radius); padding:22px; box-shadow:0 24px 60px rgba(15,23,42,0.08)}
        h1{margin:0 0 12px; color:var(--card-header-end)}

        form{display:grid; grid-template-columns:1fr 1fr; gap:14px}
        label{display:block; font-weight:600; color:var(--muted); margin-bottom:6px}
        input[type=text], select, textarea{width:100%; padding:10px 12px; border-radius:10px; border:1px solid #e6eefb; background:linear-gradient(#fff,#fbfdff)}
        textarea{min-height:120px; resize:vertical}

        .form-full{grid-column:1 / -1}
        .actions{display:flex; gap:12px; justify-content:flex-end}

        .btn{padding:10px 14px; border-radius:10px; font-weight:700; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; justify-content:center}
        .btn-primary{background:linear-gradient(135deg,var(--card-header-start),var(--card-header-end)); color:#fff; border:0}
        .btn-secondary{background:#ffffff; color:var(--text); border:1px solid #dbeafe}
        .btn-secondary:hover{background:#f8fafc; color:var(--text)}

        @media (max-width:860px){form{grid-template-columns:1fr} .actions{flex-direction:column-reverse}}
    </style>

</head>

<body>

    <div class="container">
        <div class="card">
            <h1>Editar Equipamento</h1>

            <form action="atualizar.php" method="POST">

                <input type="hidden" name="id_equipamento" value="<?= htmlspecialchars($equipamento['id_equipamento']) ?>">

                <div>
                    <label>Cliente:</label>
                    <select name="id_cliente" required>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?= $cliente['id'] ?>" <?= $cliente['id'] == $equipamento['id_cliente'] ? 'selected' : '' ?>><?= htmlspecialchars($cliente['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label>Tipo:</label>
                    <input type="text" name="tipo" value="<?= htmlspecialchars($equipamento['tipo']) ?>" required>
                </div>

                <div>
                    <label>Marca:</label>
                    <input type="text" name="marca" value="<?= htmlspecialchars($equipamento['marca']) ?>">
                </div>

                <div>
                    <label>Modelo:</label>
                    <input type="text" name="modelo" value="<?= htmlspecialchars($equipamento['modelo']) ?>">
                </div>

                <div>
                    <label>Número de Série:</label>
                    <input type="text" name="numero_serie" value="<?= htmlspecialchars($equipamento['numero_serie']) ?>">
                </div>

                <div>
                    <label>Patrimônio:</label>
                    <input type="text" name="patrimonio" value="<?= htmlspecialchars($equipamento['patrimonio']) ?>">
                </div>

                <div class="form-full">
                    <label>Descrição:</label>
                    <textarea name="descricao"><?= htmlspecialchars($equipamento['descricao']) ?></textarea>
                </div>

                <div>
                    <label>Sistema Operacional:</label>
                    <input type="text" name="sistema_operacional" value="<?= htmlspecialchars($equipamento['sistema_operacional']) ?>">
                </div>

                <div>
                    <label>Senha de Acesso:</label>
                    <input type="text" name="senha_acesso" value="<?= htmlspecialchars($equipamento['senha_acesso']) ?>">
                </div>

                <div>
                    <label>Status:</label>
                    <select name="status" required>
                        <option value="ATIVO" <?= $equipamento['status'] == 'ATIVO' ? 'selected' : '' ?>>Ativo</option>
                        <option value="INATIVO" <?= $equipamento['status'] == 'INATIVO' ? 'selected' : '' ?>>Inativo</option>
                        <option value="EM_MANUTENCAO" <?= $equipamento['status'] == 'EM_MANUTENCAO' ? 'selected' : '' ?>>Em manutenção</option>
                    </select>
                </div>

                <div class="form-full actions">
                    
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                </div>

            </form>
        </div>
    </div>

</body>

</html>