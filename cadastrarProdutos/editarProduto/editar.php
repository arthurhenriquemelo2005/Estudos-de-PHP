<?php 

    session_start();
    require __DIR__ . '/../conexao/conexao.php';


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-soft: #eaf1ff;
            --text: #1f2937;
            --muted: #64748b;
            --border: rgba(148, 163, 184, 0.25);
            --shadow: 0 18px 45px rgba(37, 99, 235, 0.15);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top, rgba(255,255,255,0.95), rgba(218, 231, 255, 0.95) 35%, #dfeaff 100%);
            color: var(--text);
        }

        form {
            width: 100%;
            max-width: 520px;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 32px 28px;
        }

        h1 {
            margin: 0 0 24px;
            text-align: center;
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: -0.04em;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 18px;
        }

        label {
            font-weight: 600;
            margin-bottom: 8px;
            color: var(--text);
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dbe4f0;
            border-radius: 12px;
            background: #f8fbff;
            color: var(--text);
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
            background: #fff;
        }

        button {
            width: 100%;
            margin-top: 8px;
            padding: 12px 16px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 20px rgba(37, 99, 235, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 22px rgba(37, 99, 235, 0.25);
        }
    </style>
</head>
<body>
    <form action="/../editarProduto/editar.php" method="POST">
        <h1>Editar Produto</h1>

        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" placeholder="Nome do produto" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="number" name="preco" step="0.1" min="1" placeholder="R$0,00" inputmode="numeric" id="preco" required>
        </div>

        <div class="form-group">
            <label for="quantidade">Quantidade:</label>
            <input type="number" name="quantidade" id="quantidade" inputmode="numeric" placeholder="Informe a quantidade" required>
        </div>

        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria" placeholder="Informe a categoria" required>
        </div>

        <button type="submit">Editar Produto</button>
    </form>
</body>
</html>