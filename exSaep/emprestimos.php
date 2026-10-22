
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

$sqlClientes = "SELECT id_cliente, nome
                FROM clientes
                ORDER BY nome ASC";

$stmtClientes = $pdo->query($sqlClientes);
$clientes = $stmtClientes->fetchAll();

$sqlFilmes = "SELECT id_filme, titulo, quantidade_disponivel
              FROM filmes
              WHERE status = 'ATIVO'
                AND quantidade_disponivel > 0
              ORDER BY titulo ASC";

$stmtFilmes = $pdo->query($sqlFilmes);
$filmes = $stmtFilmes->fetchAll();

$sqlEmprestimos = "SELECT
                        e.id_emprestimo,
                        e.data_emprestimo,
                        e.data_devolucao_prevista,
                        e.data_devolucao,
                        e.status,
                        c.nome AS nome_cliente,
                        f.titulo AS titulo_filme,
                        u.nome AS nome_usuario
                   FROM emprestimos e
                   INNER JOIN clientes c
                       ON e.id_cliente = c.id_cliente
                   INNER JOIN filmes f
                       ON e.id_filme = f.id_filme
                   INNER JOIN usuarios u
                       ON e.id_usuario = u.id_usuario
                   ORDER BY e.data_emprestimo DESC,
                            e.id_emprestimo DESC";

$stmtEmprestimos = $pdo->query($sqlEmprestimos);
$emprestimos = $stmtEmprestimos->fetchAll();

function e($valor) {
    return htmlspecialchars(
        (string) ($valor ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empréstimos | Locadora</title>
    
</head>
<body>

<header class="topbar">
    <div>
        <a href="painel.php" class="voltar">← Voltar ao painel</a>
        <h1>Empréstimos</h1>
        <p>Registre e gerencie os empréstimos da locadora.</p>
    </div>

    <span class="usuario">
        <?= e($_SESSION['nome'] ?? 'Usuário') ?>
    </span>
</header>

<main class="container">

    <?php if ($mensagem !== ''): ?>
        <div class="mensagem">
            <?= e($mensagem) ?>
        </div>
    <?php endif; ?>

    <section class="card">
        <div class="card-header">
            <h2>Novo empréstimo</h2>
            <p>Selecione um cliente, um filme e as datas.</p>
        </div>

        <form action="salvarEmprestimo.php" method="POST">

            <div class="campo">
                <label for="id_cliente">Cliente</label>

                <select id="id_cliente" name="id_cliente" required>
                    <option value="">Selecione um cliente</option>

                    <?php foreach ($clientes as $cliente): ?>
                        <option value="<?= (int) $cliente['id_cliente'] ?>">
                            <?= e($cliente['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="id_filme">Filme</label>

                <select id="id_filme" name="id_filme" required>
                    <option value="">Selecione um filme</option>

                    <?php foreach ($filmes as $filme): ?>
                        <option value="<?= (int) $filme['id_filme'] ?>">
                            <?= e($filme['titulo']) ?>
                            (Disponíveis:
                            <?= (int) $filme['quantidade_disponivel'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if (empty($filmes)): ?>
                    <p>Nenhum filme ativo disponível para empréstimo.</p>
                <?php endif; ?>
            </div>

            <div class="campo">
                <label for="data_emprestimo">Data do empréstimo</label>
                <input
                    type="date"
                    id="data_emprestimo"
                    name="data_emprestimo"
                    value="<?= date('Y-m-d') ?>"
                    required
                >
            </div>

            <div class="campo">
                <label for="data_devolucao_prevista">
                    Data prevista para devolução
                </label>

                <input
                    type="date"
                    id="data_devolucao_prevista"
                    name="data_devolucao_prevista"
                    min="<?= date('Y-m-d') ?>"
                    required
                >
            </div>

            <button type="submit" class="btn-principal">
                Registrar empréstimo
            </button>

        </form>
    </section>

    <section class="card">
        <div class="card-header">
            <h2>Empréstimos registrados</h2>
            <p><?= count($emprestimos) ?> registro(s) encontrado(s).</p>
        </div>

        <div class="tabela-container">
            <table>
                <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Filme</th>
                        <th>Funcionário</th>
                        <th>Data do empréstimo</th>
                        <th>Devolução prevista</th>
                        <th>Data da devolução</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($emprestimos)): ?>
                    <tr>
                        <td colspan="8" class="vazio">
                            Nenhum empréstimo registrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($emprestimos as $emprestimo): ?>
                        <tr>
                            <td><?= e($emprestimo['nome_cliente']) ?></td>
                            <td><?= e($emprestimo['titulo_filme']) ?></td>
                            <td><?= e($emprestimo['nome_usuario']) ?></td>

                            <td>
                                <?= e(date(
                                    'd/m/Y',
                                    strtotime($emprestimo['data_emprestimo'])
                                )) ?>
                            </td>

                            <td>
                                <?= e(date(
                                    'd/m/Y',
                                    strtotime($emprestimo['data_devolucao_prevista'])
                                )) ?>
                            </td>

                            <td>
                                <?php if ($emprestimo['data_devolucao']): ?>
                                    <?= e(date(
                                        'd/m/Y',
                                        strtotime($emprestimo['data_devolucao'])
                                    )) ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>

                            <td><?= e($emprestimo['status']) ?></td>

                            <td class="acoes">
                                <a
                                    class="btn-editar"
                                    href="editarEmprestimo.php?id=<?= (int) $emprestimo['id_emprestimo'] ?>"
                                >
                                    Editar data
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

</body>
</html>
