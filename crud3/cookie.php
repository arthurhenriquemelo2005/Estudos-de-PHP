<?php
$temaAtual = $_COOKIE['tema'] ?? 'claro';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $temaAtual = $_POST['tema'] ?? 'claro';
    $expiracao = time() + (30 * 24 * 60 * 60);
    setcookie('tema', $temaAtual, $expiracao, '/');
    $mensagem = 'Preferência salva com sucesso!';
}

$temaClaro = $temaAtual === 'claro';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuração de Tema</title>
    <style>
        :root {
            --bg: #f5f7fb;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --accent: #2563eb;
            --border: #dbe4f0;
        }

        body.dark {
            --bg: #111827;
            --card: #1f2937;
            --text: #f9fafb;
            --muted: #d1d5db;
            --accent: #60a5fa;
            --border: #374151;
        }

        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg);
            color: var(--text);
            transition: all 0.2s ease;
        }

        .card {
            width: min(420px, 90vw);
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 30px 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            font-size: 24px;
            color: var(--accent);
        }

        .tema-group {
            margin: 22px 0;
        }

        label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 12px 0;
            color: var(--text);
            font-size: 16px;
        }

        input[type="radio"] {
            accent-color: var(--accent);
            width: 18px;
            height: 18px;
        }

        button {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
        }

        .mensagem {
            margin-top: 18px;
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>
<body class="<?= $temaClaro ? 'light' : 'dark'; ?>">
    <div class="card">
        <h1>Preferência de tema</h1>

        <form method="post">
            <div class="tema-group">
                <label>
                    <input type="radio" name="tema" value="claro" <?= $temaAtual === 'claro' ? 'checked' : ''; ?>>
                    Claro
                </label>

                <label>
                    <input type="radio" name="tema" value="escuro" <?= $temaAtual === 'escuro' ? 'checked' : ''; ?>>
                    Escuro
                </label>
            </div>

            <button type="submit">Salvar preferência</button>
        </form>

        <?php if (isset($mensagem)): ?>
            <div class="mensagem"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
