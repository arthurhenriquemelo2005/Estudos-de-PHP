<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login/login.php');
    exit;
}

require_once __DIR__ . '/../../conexao/conexao.php';

$busca = trim($_GET['busca'] ?? '');

$sql = "
    SELECT
        p.id_participante,
        u.nome,
        u.email,
        p.telefone,
        p.cidade,
        p.estado,
        p.saldo_ecopoints,
        p.data_cadastro
    FROM participante p
    INNER JOIN usuario u
        ON u.id_usuario = p.id_usuario
    WHERE 1 = 1
";

$params = [];

if ($busca !== '') {
    $sql .= "
        AND (
            u.nome LIKE :nome
            OR u.email LIKE :email
            OR p.telefone LIKE :telefone
        )
    ";

    $params['nome'] = "%{$busca}%";
    $params['email'] = "%{$busca}%";
    $params['telefone'] = "%{$busca}%";
}

$sql .= " ORDER BY p.data_cadastro DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Participantes | EcoPoint</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style1.css">
</head>

<body>

    <header class="topbar">
        <a href="../../painel/painel.php" class="brand">
            <span class="brand-mark">E</span>
            <span>EcoPoint</span>
        </a>

        <div class="user-area">
            <span>Participantes</span>
            <a href="../../painel/logout.php" class="btn-sair">Sair</a>
        </div>
    </header>

    <main class="container page-content">

        <div class="page-heading">
            <div>
                <span class="eyebrow">GESTÃO DO SISTEMA</span>
                <h1>Participantes</h1>
                <p>Consulte e gerencie os participantes cadastrados no EcoPoint.</p>
            </div>

            <a href="cadastrar.php" class="btn-eco">
                + Novo participante
            </a>
        </div>

        <section class="content-card">

            <div class="card-heading">
                <div>
                    <h2>Lista de participantes</h2>
                    <p>
                        <?= count($participantes) ?>
                        participante(s) encontrado(s)
                    </p>
                </div>
            </div>

            <form method="GET" class="search-form">

                <div class="search-field">
                    <input
                        type="search"
                        name="busca"
                        class="form-control"
                        placeholder="Buscar por nome ou e-mail..."
                        value="<?= escapar($busca) ?>">
                </div>

                <button type="submit" class="btn-eco">
                    Buscar
                </button>

                <?php if ($busca !== ''): ?>
                    <a href="index.php" class="btn-clear">
                        Limpar
                    </a>
                <?php endif; ?>

            </form>

            <div class="table-responsive">

                <table class="table align-middle participants-table">

                    <thead>
                        <tr>
                            <th>Participante</th>
                            <th>Telefone</th>
                            <th>Localização</th>
                            <th>EcoPoints</th>
                            <th>Cadastro</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (count($participantes) > 0): ?>

                            <?php foreach ($participantes as $participante): ?>

                                <tr>
                                    <td>
                                        <div class="participant-name">
                                            <?= escapar($participante['nome']) ?>
                                        </div>

                                        <div class="participant-email">
                                            <?= escapar($participante['email']) ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?= escapar($participante['telefone']) ?>
                                    </td>

                                    <td>
                                        <?= escapar($participante['cidade']) ?> /
                                        <?= escapar($participante['estado']) ?>
                                    </td>

                                    <td>
                                        <span class="points-badge">
                                            <?= number_format(
                                                (int) $participante['saldo_ecopoints'],
                                                0,
                                                ',',
                                                '.'
                                            ) ?>
                                            pts
                                        </span>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($participante['data_cadastro'])
                                        ) ?>
                                    <td>
                                        <div class="action-buttons">

                                            <a
                                                href="editar.php?id=<?= (int) $participante['id_participante'] ?>"
                                                class="btn-edit">
                                                Editar
                                            </a>

                                            <a
                                                href="excluir.php?id=<?= (int) $participante['id_participante'] ?>"
                                                class="btn-delete"
                                                onclick="return confirm('Tem certeza que deseja excluir este participante?')">
                                                Excluir
                                            </a>

                                        </div>
                                    </td>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="5" class="empty-state">
                                    <strong>Nenhum participante encontrado.</strong>
                                    <p>
                                        <?php if ($busca !== ''): ?>
                                            Tente pesquisar por outro nome ou e-mail.
                                        <?php else: ?>
                                            Cadastre o primeiro participante para começar.
                                        <?php endif; ?>
                                    </p>
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </section>

        <a href="../../painel/painel.php" class="back-link">
            ← Voltar ao painel principal
        </a>

    </main>

    <footer>
        <p>
            &copy; <?= date('Y') ?> EcoPoint — Sistema de gestão de coleta sustentável.
        </p>
    </footer>

</body>

</html>
