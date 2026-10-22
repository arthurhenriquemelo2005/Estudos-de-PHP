
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

$id = filter_input(INPUT_POST, 'id_emprestimo', FILTER_VALIDATE_INT);
$data_emprestimo = $_POST['data_emprestimo'] ?? '';
$data_prevista = $_POST['data_devolucao_prevista'] ?? '';

$dataEmprestimoValida = DateTime::createFromFormat('!Y-m-d', $data_emprestimo);
$dataPrevistaValida = DateTime::createFromFormat('!Y-m-d', $data_prevista);

if (
    !$id ||
    !$dataEmprestimoValida ||
    $dataEmprestimoValida->format('Y-m-d') !== $data_emprestimo ||
    !$dataPrevistaValida ||
    $dataPrevistaValida->format('Y-m-d') !== $data_prevista ||
    $data_prevista < $data_emprestimo
) {
    $_SESSION['mensagem'] = 'Informe datas válidas. A devolução prevista não pode ser anterior ao empréstimo.';
    header("Location: emprestimos.php");
    exit;
}

try {
    $sql = "UPDATE emprestimos
            SET data_emprestimo = :data_emprestimo,
                data_devolucao_prevista = :data_prevista
            WHERE id_emprestimo = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':data_emprestimo' => $data_emprestimo,
        ':data_prevista' => $data_prevista,
        ':id' => $id
    ]);

    $_SESSION['mensagem'] = 'Datas do empréstimo atualizadas com sucesso!';

} catch (PDOException $e) {
    $_SESSION['mensagem'] = 'Erro ao atualizar as datas do empréstimo.';
}

header("Location: emprestimos.php");
exit;
