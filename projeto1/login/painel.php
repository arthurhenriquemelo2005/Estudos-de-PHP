<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['nome'];
$perfil = $_SESSION['perfil'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Painel - Assistência Técnica</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #0f172a;
        }

        .topbar {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #fff;
            padding: 24px 32px;
            box-shadow: 0 12px 32px rgba(37, 99, 235, 0.18);
        }

        .topbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand {
            font-size: clamp(1.5rem, 2vw, 2rem);
            font-weight: 700;
            margin: 0;
        }

        .usuario {
            text-align: right;
            font-size: 0.96rem;
        }

        .usuario p {
            margin: 0 0 4px;
            font-weight: 600;
        }

        .usuario small {
            opacity: 0.9;
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 56px;
        }

        .boas-vindas {
            margin-bottom: 28px;
        }

        .boas-vindas h2 {
            margin: 0 0 8px;
            color: #1e293b;
            font-size: clamp(1.8rem, 3vw, 2.4rem);
        }

        .boas-vindas p {
            margin: 0;
            color: #475569;
            font-size: 1rem;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 22px;
        }

        .card {
            display: block;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 20px;
            padding: 28px 22px;
            text-decoration: none;
            color: #1e293b;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 44px rgba(37, 99, 235, 0.12);
            text-decoration: none;
            color: #1e293b;
        }

        .icone {
            font-size: 2.5rem;
            margin-bottom: 18px;
        }

        .card h3 {
            margin: 0 0 8px;
            font-size: 1.3rem;
        }

        .card p {
            margin: 0;
            color: #64748b;
            line-height: 1.5;
            font-size: 0.95rem;
        }

        .actions {
            margin-top: 30px;
        }

        .sair {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 14px 28px rgba(220, 38, 38, 0.18);
            transition: 0.2s ease;
        }

        .sair:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: #fff;
            text-decoration: none;
        }
    </style>

</head>

<body>

<header class="topbar">
    <div class="topbar-inner">
        <h1 class="brand">Assistência Técnica</h1>

        <div class="usuario">
            <p>Olá, <strong><?= htmlspecialchars($nome) ?></strong></p>
            <small>Perfil: <?= htmlspecialchars($perfil) ?></small>
        </div>
    </div>
</header>

<main>
    <div class="boas-vindas">
        <h2>Painel de Controle</h2>
        <p>Selecione uma opção para gerenciar o sistema.</p>
    </div>

    <div class="cards">
        <a href="../clientes/index.php" class="card">
            <div class="icone">👤</div>
            <h3>Clientes</h3>
            <p>Cadastre e gerencie os clientes da assistência.</p>
        </a>

        <a href="../equipamentos/index.php" class="card">
            <div class="icone">💻</div>
            <h3>Equipamentos</h3>
            <p>Gerencie os equipamentos dos clientes.</p>
        </a>

        <a href="../tecnico/index.php" class="card">
            <div class="icone">🔧</div>
            <h3>Técnicos</h3>
            <p>Cadastre e gerencie os técnicos.</p>
        </a>

        <a href="../servicos/index.php" class="card">
            <div class="icone">🛠️</div>
            <h3>Ordens de Serviço</h3>
            <p>Crie e acompanhe as ordens de serviço.</p>
        </a>
    </div>

    <div class="actions">
        <a href="logout.php" class="sair">Sair</a>
    </div>
</main>

</body>

</html>