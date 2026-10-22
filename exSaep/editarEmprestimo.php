
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensagem'] = 'Empréstimo inválido.';
    header("Location: emprestimos.php");
    exit;
}

$stmt = $pdo->prepare(
    "SELECT id_emprestimo, data_emprestimo,
            data_devolucao_prevista, status
     FROM emprestimos
     WHERE id_emprestimo = :id"
);
$stmt->execute([':id' => $id]);
$emprestimo = $stmt->fetch();

if (!$emprestimo) {
    $_SESSION['mensagem'] = 'Empréstimo não encontrado.';
    header("Location: emprestimos.php");
    exit;
}

function e($valor) {
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar empréstimo | Locadora</title>
</head>
<body>

<main class="container">
    <h1>Editar empréstimo</h1>

    <p>Status atual: <?= e($emprestimo['status']) ?></p>

    <form action="atualizarEmprestimo.php" method="POST">
        <input
            type="hidden"
            name="id_emprestimo"
            value="<?= (int) $emprestimo['id_emprestimo'] ?>"
        >

        <div class="campo">
            <label for="data_emprestimo">Data do empréstimo</label>
            <input
                type="date"
                id="data_emprestimo"
                name="data_emprestimo"
                value="<?= e($emprestimo['data_emprestimo']) ?>"
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
                value="<?= e($emprestimo['data_devolucao_prevista']) ?>"
                min="<?= e($emprestimo['data_emprestimo']) ?>"
                required
            >
        </div>

        <button type="submit" class="btn-principal">
            Atualizar datas
        </button>

        <a href="emprestimos.php">Cancelar</a>
    </form>
</main>

</body>
</html>
