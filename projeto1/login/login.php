<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --bg-1: #f8fbff;
            --bg-2: #dfeeff;
            --text: #0f172a;
            --muted: #64748b;
            --white: #ffffff;
        }

        body {
            background: radial-gradient(circle at top left, var(--bg-2), var(--bg-1) 40%, #eef4ff 100%);
            min-height: 100vh;
            color: var(--text);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            min-height: 100vh;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: 0;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(10px);
            box-shadow: 0 24px 60px rgba(37, 99, 235, 0.12);
            overflow: hidden;
        }

        .card-body {
            padding: 2.25rem 2rem 2rem;
        }

        .brand-badge {
            width: 72px;
            height: 72px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 16px 32px rgba(37, 99, 235, 0.25);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: var(--white);
            font-size: 1.8rem;
            font-weight: 700;
        }

        .login-title {
            font-size: 2rem;
            letter-spacing: -0.03em;
            margin-bottom: 0.3rem;
        }

        .login-subtitle {
            color: var(--muted);
            font-size: 0.96rem;
            margin-bottom: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 12px;
            border: 1.5px solid #dbe4f0;
            padding: 0.9rem 1rem;
            font-size: 1rem;
            transition: all 0.2s ease;
            background: #f8fbff;
        }

        .form-control:focus {
            border-color: rgba(37, 99, 235, 0.7);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
            background: var(--white);
        }

        .btn-primary {
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            box-shadow: 0 12px 22px rgba(37, 99, 235, 0.25);
            font-weight: 600;
            padding: 0.9rem 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 28px rgba(37, 99, 235, 0.32);
        }
    </style>
</head>
<body>
    <div class="container login-wrapper d-flex align-items-center justify-content-center">
        <div class="card login-card">
            <div class="card-body">
                <div class="text-center">
                    <h2 class="login-title fw-bold">Login</h2>
                    <p class="login-subtitle">Acesse sua conta</p>
                </div>

                <form action="autenticar.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="seu@email.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha</label>
                        <input type="password" class="form-control form-control-lg" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Entrar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>