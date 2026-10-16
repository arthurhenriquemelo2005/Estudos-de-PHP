<?php
session_start();
require_once __DIR__ . '/../conexao/conexao.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email !== '' && $senha !== '') {
        $sql = "SELECT * FROM Usuario WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];

            header('Location: ../painel.php');
            exit;
        }

        $erro = 'Email ou senha inválidos.';
    } else {
        $erro = 'Preencha email e senha.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eafaf1 0%, #f6fff8 40%, #ebf7ee 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 1100px;
            background: #ffffff;
            border-radius: 28px;
            overflow: hidden;
            box-shadow: 0 18px 50px rgba(19, 90, 53, 0.12);
        }

        .left-panel {
            background: linear-gradient(180deg, #1d7a45 0%, #0f5c34 100%);
            color: white;
            padding: 60px 40px;
        }

        .brand-badge {
            display: inline-block;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: bold;
        }

        .left-panel h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-top: 20px;
        }

        .left-panel p {
            color: rgba(255,255,255,0.9);
            font-size: 1.05rem;
            margin-top: 15px;
            line-height: 1.7;
        }

        .eco-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            border-radius: 18px;
            padding: 18px 20px;
            margin-top: 28px;
        }

        .eco-card small {
            display: block;
            color: rgba(255,255,255,0.8);
        }

        .form-panel {
            padding: 50px 40px;
            background: #fff;
        }

        .form-panel h2 {
            color: #1f3d2e;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .text-muted-soft {
            color: #5d7669;
        }

        .form-control {
            border-radius: 12px;
            border: 1px solid #dfeae3;
            padding: 12px 14px;
            background: #f8fbf9;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #2e9e5d;
            background: white;
        }

        .btn-eco {
            background: linear-gradient(135deg, #2fa85d 0%, #1d7a45 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 18px;
            font-weight: 600;
            transition: 0.3s ease;
        }

        .btn-eco:hover {
            background: linear-gradient(135deg, #24864d 0%, #175f38 100%);
        }

        .alert-custom {
            border-radius: 12px;
            border: 1px solid #f8d7da;
            background: #fff3f4;
            color: #8a1c22;
            padding: 12px 14px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .alert-custom::before {
            content: '⚠';
            font-size: 1.1rem;
            line-height: 1;
        }

        .link-green {
            color: #1d7a45;
            text-decoration: none;
            font-weight: 600;
        }

        .link-green:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box row g-0 mx-auto">
            <div class="col-lg-5 left-panel">
                <span class="brand-badge">♻️ EcoPoint</span>
                <h1>Junte-se à mudança sustentável.</h1>
                <p>
                    Acompanhe o destino do seu lixo, participe de campanhas e ajude a construir um futuro mais limpo e consciente.
                </p>

                <div class="eco-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>12.4k</strong><br>
                            <small>pessoas ativas</small>
                        </div>
                        <div>
                            <strong>8.2t</strong><br>
                            <small>recicladas</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 form-panel">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2>Entrar</h2>
                        <p class="text-muted-soft mb-0">Acesse sua conta</p>
                    </div>
                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">online</span>
                </div>

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-custom" role="alert">
                        <?= htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="painel.php">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="senha" class="form-label fw-semibold">Senha</label>
                        <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="lembrar">
                            <label class="form-check-label text-muted-soft" for="lembrar">
                                Lembrar-me
                            </label>
                        </div>
                        <a href="#" class="link-green">Esqueci a senha</a>
                    </div>

                    <button type="submit" class="btn btn-eco w-100 text-white">Entrar</button>
                </form>

                <div class="text-center mt-4">
                    <span class="text-muted-soft">Ainda não tem conta?</span>
                    <a href="#" class="link-green ms-1">Cadastre-se</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
