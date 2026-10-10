<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #edf4ff;
            --text: #1f2937;
            --muted: #64748b;
            --success: #198754;
            --shadow: 0 18px 45px rgba(37, 99, 235, 0.18);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: radial-gradient(circle at top, rgba(255,255,255,0.9), rgba(218, 231, 255, 0.95) 35%, #dfeaff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text);
        }

        .login-card {
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(148, 163, 184, 0.2);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: var(--shadow);
            backdrop-filter: blur(8px);
            padding: 2.2rem;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.3rem;
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        h1 {
            font-size: clamp(1.8rem, 3vw, 2.2rem);
            font-weight: 700;
            letter-spacing: -0.04em;
            color: var(--primary-dark);
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--muted);
            font-size: 0.96rem;
            margin-bottom: 1.75rem;
        }

        .form-label {
            color: var(--text);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border: 1.5px solid #dfe7ff;
            border-radius: 12px;
            background-color: #f8fbff;
            padding: 0.8rem 0.9rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: #9bbdff;
            box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.12);
            background-color: #fff;
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-color: var(--primary);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary));
            border-color: var(--primary-dark);
        }

        .text-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .helper-text {
            margin-top: 1rem;
            text-align: center;
            color: var(--muted);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
           
        </div>

        <h1 class="text-center">Criar conta</h1>
        <p class="subtitle text-center">Cadastre-se para acessar o sistema.</p>

        <form action="cadastrarUsuario.php" method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome completo</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@empresa.com" required>
            </div>

            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha" required>
            </div>

            <div class="mb-3">
                <label for="confirmarSenha" class="form-label">Confirmar senha</label>
                <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" placeholder="Repita a senha" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2">Cadastrar</button>

            <div class="helper-text">
                Já tem conta? <a href="../login/login.php" class="text-link">Entrar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
