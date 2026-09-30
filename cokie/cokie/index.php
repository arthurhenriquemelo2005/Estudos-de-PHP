<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Sistema de Acesso</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: radial-gradient(circle at top, #f8fbff 0%, #edf4ff 35%, #e2e8f0 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            color: #0f172a;
        }

        h1 {
            color: #0f172a;
            margin-bottom: 24px;
            font-size: 2.1rem;
            letter-spacing: 0.5px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 16px;
            background: rgba(255, 255, 255, 0.95);
            padding: 32px 30px 28px;
            border-radius: 16px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            width: 100%;
            max-width: 380px;
            border: 1px solid rgba(148, 163, 184, 0.2);
        }

        label {
            display: block;
            color: #334155;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 6px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            box-sizing: border-box;
            font-size: 14px;
            background: #f8fafc;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
            margin: 0;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #3b82f6;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
        }

        br {
            display: none;
        }

        button {
            width: 100%;
            padding: 13px 14px;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
            box-shadow: 0 8px 18px rgba(37, 99, 235, 0.28);
        }

        button:hover {
            transform: translateY(-1px);
            filter: brightness(1.03);
        }
    </style>

</head>

<body>

    <h1>Sistema de Acesso</h1>

    <form action="autenticar.php" method="post">

        <label>Usuário:</label>

        <input
            type="text"
            name="usuario"
            required
        >         
        

        <br><br>
        
        <label>Senha:</label>
        
        <input
            type="password"
            name="senha"
            id="senha"
            required>

            <br><br>
        <button type="submit">
            Entrar
        </button>
        
    </form>

</body>

</html>

