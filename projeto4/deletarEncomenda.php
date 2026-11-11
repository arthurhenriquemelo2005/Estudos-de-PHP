
<?php
session_start();

require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['deletar'])) {
    header('Location: listarEncomendas.php');
    exit;
}

$idEncomenda = filter_input(INPUT_POST, 'id_encomenda', FILTER_VALIDATE_INT);

if (!$idEncomenda) {
    header('Location: listarEncomendas.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $sqlItens = "DELETE FROM itens_encomenda
                 WHERE id_encomenda = :id";

    $stmtItens = $pdo->prepare($sqlItens);
    $stmtItens->execute([
        ':id' => $idEncomenda
    ]);

    $sqlEncomenda = "DELETE FROM encomendas
                     WHERE id_encomenda = :id";

    $stmtEncomenda = $pdo->prepare($sqlEncomenda);
    $stmtEncomenda->execute([
        ':id' => $idEncomenda
    ]);

    $pdo->commit();

    header('Location: listarEncomendas.php');
    exit;
} catch (PDOException $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    die("Erro ao excluir encomenda: " . htmlspecialchars($e->getMessage()));
}
?>
