<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Autenticação</title>
    <style>
        :root{--bg:#f5f7fb;--card:#fff;--accent:#1e90ff;--muted:#6b7280}
        *{box-sizing:border-box;font-family:Segoe UI,Arial,Helvetica,sans-serif}
        body{margin:0;background:linear-gradient(180deg,#eef6ff 0%,var(--bg)100%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
        .card{background:var(--card);padding:28px;border-radius:12px;max-width:420px;width:100%;box-shadow:0 10px 30px rgba(30,144,255,0.08)}
        h1{margin:0 0 18px;color:var(--accent);font-size:22px}
        label{display:block;margin-bottom:6px;color:var(--muted);font-size:13px}
        input[type="email"],input[type="password"]{width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e6eef8;margin-bottom:14px;font-size:14px}
        .actions{display:flex;gap:8px;align-items:center;justify-content:space-between}
        input[type="submit"]{background:var(--accent);color:#fff;border:none;padding:10px 14px;border-radius:8px;cursor:pointer}
        .btn-cadastrar{background:#fff;border:1px solid #cfe6ff;color:var(--accent);padding:10px 14px;border-radius:8px;cursor:pointer;text-decoration:none;font-size:13px}
        .small{font-size:13px;color:var(--muted);margin-top:16px}
    </style>
</head>
<body>
    <div class="card">
        <form action="consultar.php" method="post">
            <h1>Login</h1>
            
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" placeholder="Informe seu e-mail" required>
            
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Informe sua senha" required>
            
            <div class="actions">
                <input type="submit" value="Entrar">
                <a class="btn-cadastrar" href="cadastro.php">Cadastrar</a>
            </div>
            
            <p class="small">Não tem conta? Clique em "Cadastrar" para criar uma.</p>
        </form>
    </div>
</body>
</html>