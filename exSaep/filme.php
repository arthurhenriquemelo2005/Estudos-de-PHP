<?php

session_start();
require_once "conexao.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT * FROM filmes";
$stmt = $pdo->query($sql);
$filmes = $stmt->fetchAll();

function e($valor)
{
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
    <title>Filmes | Locadora</title>
    <link rel="stylesheet" href="filmes.css">
</head>
<body>

<header class="topbar">
    <div>
        <a href="painel.php" class="voltar">← Voltar ao painel</a>
        <h1>Acervo de filmes</h1>
        <p>Cadastre e gerencie os filmes da locadora.</p>
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
            <h2>Novo filme</h2>
            <p>Informe os dados do filme para adicioná-lo ao acervo.</p>
        </div>

        <form action="salvarFilme.php" method="POST">
            <div class="form-grid">

                <div class="campo campo-largo">
                    <label for="titulo">Título do filme</label>
                    <input
                        type="text"
                        id="titulo"
                        name="titulo"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="categoria">Categoria</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Selecione</option>
                        <option value="Filme">Filme</option>
                        <option value="Documentário">Documentário</option>
                        <option value="Animação">Animação</option>
                        <option value="Curta-metragem">Curta-metragem</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="genero">Gênero</label>
                    <select id="genero" name="genero" required>
                        <option value="">Selecione</option>
                        <option value="Ação">Ação</option>
                        <option value="Aventura">Aventura</option>
                        <option value="Comédia">Comédia</option>
                        <option value="Drama">Drama</option>
                        <option value="Ficção científica">Ficção científica</option>
                        <option value="Fantasia">Fantasia</option>
                        <option value="Terror">Terror</option>
                        <option value="Romance">Romance</option>
                        <option value="Suspense">Suspense</option>
                        <option value="Animação">Animação</option>
                        <option value="Documentário">Documentário</option>
                        <option value="Outro">Outro</option>
                    </select>
                </div>

                <div class="campo">
                    <label for="ano_lancamento">Ano de lançamento</label>
                    <input
                        type="number"
                        id="ano_lancamento"
                        name="ano_lancamento"
                        min="1888"
                        max="<?= date('Y') ?>"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="diretor">Diretor</label>
                    <input
                        type="text"
                        id="diretor"
                        name="diretor"
                        maxlength="100"
                    >
                </div>

                <div class="campo">
                    <label for="quantidade_total">Quantidade de cópias</label>
                    <input
                        type="number"
                        id="quantidade_total"
                        name="quantidade_total"
                        min="1"
                        value="1"
                        required
                    >
                </div>

            </div>

            <button type="submit" class="btn-principal">
                Cadastrar filme
            </button>
        </form>
    </section>

    <section class="card">
        <div class="card-header lista-header">
            <div>
                <h2>Filmes cadastrados</h2>
                <p><?= count($filmes) ?> filme(s) no acervo.</p>
            </div>
        </div>

        <div class="tabela-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Gênero</th>
                        <th>Ano</th>
                        <th>Cópias</th>
                        <th>Disponíveis</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (empty($filmes)): ?>
                    <tr>
                        <td colspan="8" class="vazio">
                            Nenhum filme cadastrado no acervo.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($filmes as $filme): ?>
                        <tr>
                            <td>#<?= (int) $filme['id_filme'] ?></td>
                            <td><?= e($filme['titulo']) ?></td>
                            <td><?= e($filme['categoria'] ?? '-') ?></td>
                            <td><?= e($filme['genero'] ?? '-') ?></td>
                            <td><?= e($filme['ano_lancamento'] ?? '-') ?></td>
                            <td><?= (int) $filme['quantidade_total'] ?></td>
                            <td><?= (int) $filme['quantidade_disponivel'] ?></td>
                            <td><?= e($filme['status']) ?></td>
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