
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: emprestimos.php");
    exit;
}

$id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
$id_filme = filter_input(INPUT_POST, 'id_filme', FILTER_VALIDATE_INT);
$data_emprestimo = $_POST['data_emprestimo'] ?? '';
$data_prevista = $_POST['data_devolucao_prevista'] ?? '';
$id_usuario = (int) $_SESSION['id_usuario'];

$dataEmprestimoValida = DateTime::createFromFormat('!Y-m-d', $data_emprestimo);
$dataPrevistaValida = DateTime::createFromFormat('!Y-m-d', $data_prevista);

if (
    !$id_cliente ||
    !$id_filme ||
    !$dataEmprestimoValida ||
    $dataEmprestimoValida->format('Y-m-d') !== $data_emprestimo ||
    !$dataPrevistaValida ||
    $dataPrevistaValida->format('Y-m-d') !== $data_prevista ||
    $data_prevista < $data_emprestimo
) {
    $_SESSION['mensagem'] = 'Verifique os dados e as datas do empréstimo.';
    header("Location: emprestimos.php");
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare(
        "SELECT id_cliente FROM clientes WHERE id_cliente = :id"
    );
    $stmt->execute([':id' => $id_cliente]);

    if (!$stmt->fetch()) {
        throw new Exception('Cliente não encontrado.');
    }

    $stmt = $pdo->prepare(
        "SELECT quantidade_disponivel
         FROM filmes
         WHERE id_filme = :id
           AND status = 'ATIVO'
         FOR UPDATE"
    );
    $stmt->execute([':id' => $id_filme]);
    $filme = $stmt->fetch();

    if (!$filme || (int) $filme['quantidade_disponivel'] < 1) {
        throw new Exception('Filme indisponível para empréstimo.');
    }

    $sql = "INSERT INTO emprestimos
                (id_cliente, id_filme, id_usuario,
                 data_emprestimo, data_devolucao_prevista, status)
            VALUES
                (:cliente, :filme, :usuario, :data_emprestimo,
                 :data_prevista, 'EMPRESTADO')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cliente' => $id_cliente,
        ':filme' => $id_filme,
        ':usuario' => $id_usuario,
        ':data_emprestimo' => $data_emprestimo,
        ':data_prevista' => $data_prevista
    ]);

    $stmt = $pdo->prepare(
        "UPDATE filmes
         SET quantidade_disponivel = quantidade_disponivel - 1
         WHERE id_filme = :id"
    );
    $stmt->execute([':id' => $id_filme]);

    $pdo->commit();

    $_SESSION['mensagem'] = 'Empréstimo registrado com sucesso!';

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION['mensagem'] = $e instanceof PDOException
        ? 'Erro no banco de dados ao registrar o empréstimo.'
        : $e->getMessage();
}

header("Location: emprestimos.php");
exit;
