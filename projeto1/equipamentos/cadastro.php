<?php

session_start();

require "../conexao/conexao.php";

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

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

    <title>Cadastrar Equipamento</title>

    <style>
        :root{
            --bg-start: #f8fafc;
            --bg-end: #dbeafe;
            --card-header-start: #2563eb;
            --card-header-end: #1d4ed8;
            --card-bg: rgba(255,255,255,0.98);
            --accent: #2563eb;
            --text: #0f172a;
            --muted: #6b7280;
            --muted-2: #94a3b8;
            --danger: #b91c1c;
            --radius: 12px;
            --gap: 16px;
        }

        *{box-sizing:border-box}
        body{
            font-family: "Segoe UI", Tahoma, Arial, sans-serif;
            background: linear-gradient(135deg,var(--bg-start) 0%, var(--bg-end) 100%);
            margin:0; padding:32px; color:var(--text); -webkit-font-smoothing:antialiased;
        }

        .container{max-width:980px; margin:0 auto}

        .card{
            background:var(--card-bg);
            border-radius:var(--radius);
            box-shadow:0 24px 60px rgba(15,23,42,0.10);
            padding:24px;
            border:1px solid rgba(37,99,235,0.04);
        }

        h1{font-size:1.4rem; margin:0 0 12px; color:var(--card-header-end)}

        form{display:grid; grid-template-columns:repeat(2,1fr); gap:var(--gap)}

        label{display:block; font-size:0.85rem; color:var(--muted); margin-bottom:8px; font-weight:600}

        input[type=text], select, textarea{
            width:100%; padding:12px 14px; border:1px solid #e6eefb; border-radius:10px; font-size:0.95rem; color:var(--text);
            background:linear-gradient(180deg, #ffffff, #fbfdff);
            transition:box-shadow .12s ease, border-color .12s ease, transform .08s ease;
        }

        input[type=text]:focus, select:focus, textarea:focus{
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 6px 18px rgba(37,99,235,0.12);
            transform: translateY(-1px);
        }

        select{appearance:none; background-image:linear-gradient(45deg, transparent 50%, rgba(0,0,0,0.4) 50%), linear-gradient(135deg, rgba(0,0,0,0.2) 50%, transparent 50%); background-position:calc(100% - 16px) calc(1em + 2px), calc(100% - 11px) calc(1em + 2px); background-size:6px 6px, 6px 6px; background-repeat:no-repeat}

        textarea{min-height:140px; resize:vertical}

        .form-full{grid-column:1 / -1}

        .actions{display:flex; gap:12px; align-items:center; justify-content:flex-end}


        .btn{display:inline-block; padding:10px 16px; border-radius:10px; border:0; cursor:pointer; font-weight:700; font-size:0.95rem; text-decoration:none; text-align:center}

        /* botão primário — padrão azul do sistema */
        .btn-primary{
            background: linear-gradient(135deg,var(--card-header-start) 0%, var(--card-header-end) 100%);
            color:#fff; box-shadow:0 8px 24px rgba(37,99,235,0.14); border:1px solid rgba(15,23,42,0.04);
        }

        .btn-primary:hover{filter:brightness(.98)}

        .btn-primary:focus{outline:3px solid rgba(37,99,235,0.12); outline-offset:2px}

        /* secundário neutro */
        .btn-secondary{background:#f3f4f6; color:#0f172a; border:1px solid rgba(2,6,23,0.06)}

        .btn-excluir{background:#fee2e2; color:var(--danger); border-radius:10px; padding:8px 12px; border:0}

        .field-help{font-size:0.8rem; color:var(--muted-2); margin-top:6px}

        /* small screens */
        @media (max-width:860px){
            form{grid-template-columns:1fr}
            .actions{justify-content:stretch; flex-direction:column-reverse; gap:10px}
            .actions .btn{width:100%}
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="card">

            <h1>Cadastrar Equipamento</h1>

            <form action="cadastrar.php" method="POST">

                <div>
                    <label>Cliente:</label>

                    <select name="id_cliente" required>

                        <option value="">
                            Selecione o cliente
                        </option>

                        <?php foreach ($clientes as $cliente): ?>

                            <option value="<?= $cliente['id'] ?>">
                                <?= $cliente['nome'] ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>


                <div>
                    <label>Tipo:</label>

                    <input
                        type="text"
                        name="tipo"
                        required>
                </div>


                <div>
                    <label>Marca:</label>

                    <input
                        type="text"
                        name="marca">
                </div>


                <div>
                    <label>Modelo:</label>

                    <input
                        type="text"
                        name="modelo">
                </div>


                <div>
                    <label>Número de Série:</label>

                    <input
                        type="text"
                        name="numero_serie">
                </div>


                <div>
                    <label>Patrimônio:</label>

                    <input
                        type="text"
                        name="patrimonio">
                </div>


                <div class="form-full">

                    <label>Descrição:</label>

                    <textarea name="descricao"></textarea>

                </div>


                <div>
                    <label>Sistema Operacional:</label>

                    <input
                        type="text"
                        name="sistema_operacional">
                </div>


                <div>
                    <label>Senha de Acesso:</label>

                    <input
                        type="text"
                        name="senha_acesso">
                </div>


                <div>
                    <label>Status:</label>

                    <select name="status" required>

                        <option value="ATIVO">
                            Ativo
                        </option>

                        <option value="INATIVO">
                            Inativo
                        </option>

                        <option value="EM_MANUTENCAO">
                            Em manutenção
                        </option>

                    </select>

                </div>


                <div class="form-full actions">
                 
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Cadastrar</button>
                </div>

            </form>

        </div>

    </div>

</body>

</html>