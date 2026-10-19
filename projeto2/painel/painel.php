<?php 

    session_start();

    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login/login.php');
        exit;
    }

    $nomeUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';
    $perfilUsuario = $_SESSION['usuario_perfil'] ?? 'PARTICIPANTE';

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<link rel="stylesheet" href="style.css">
</head>
<body>
    
    <header>
        <div>
            <h1>EcoPoint</h1>
            <p>Sustentabilidade que gera recompensas.</p>
        </div>

        <div>
            <p>Olá, <?= htmlspecialchars($nomeUsuario, ENT_QUOTES, 'UTF-8') ?></p>
            <p>Perfil: <?= htmlspecialchars($perfilUsuario, ENT_QUOTES, 'UTF-8') ?></p>
            <a href="logout.php">Sair</a>
        </div>
    </header>

    <main>
        <section>
            <h2>Painel Principal</h2>
            <p>Selecione um módulo para continuar.</p>
        </section>

        <section class="modulos">

            <article class="modulo">
                <h3>Participantes</h3>
                <p>Cadastro, listagem, busca e edição de participantes.</p>
                <a href="../paginas/participantes/participantes.php">Acessar módulo</a>
            </article>

            <article class="modulo">
                <h3>Agendamentos</h3>
                <p>Criação, alteração e cancelamento de agendamentos.</p>
                <a href="../paginas/agendamentos/agendamentos.php">Acessar módulo</a>
            </article>

            <article class="modulo">
                <h3>Confirmação da Coleta</h3>
                <p>Registro do peso coletado e geração de ecopontos.</p>
                <a href="#">Acessar módulo</a>
            </article>

            <article class="modulo">
                <h3>Carteira</h3>
                <p>Consulta de saldo e histórico de movimentações.</p>
                <a href="#">Acessar módulo</a>
            </article>

            <article class="modulo">
                <h3>Cupons</h3>
                <p>Catálogo de cupons e troca utilizando ecopontos.</p>
                <a href="#">Acessar módulo</a>
            </article>

        </section>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> EcoPoint — Sistema de gestão de coleta sustentável.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>