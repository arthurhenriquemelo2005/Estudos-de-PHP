
<?php

session_start();

require_once __DIR__ . '/../../conexao/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: participantes.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id_participante', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header('Location: participantes.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $sql = "
        SELECT id_participante
        FROM participante
        WHERE id_participante = :id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);

    $participante = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$participante) {
        $pdo->rollBack();

        header('Location: participantes.php');
        exit;
    }

    $sqlAgendamentos = "
        SELECT COUNT(*)
        FROM agendamento
        WHERE id_participante = :id
    ";

    $stmtAgendamentos = $pdo->prepare($sqlAgendamentos);
    $stmtAgendamentos->execute([
        ':id' => $id
    ]);

    $totalAgendamentos = (int) $stmtAgendamentos->fetchColumn();

    if ($totalAgendamentos > 0) {
        $pdo->rollBack();

        exit(
            'Não é possível excluir este participante, pois ele possui '
            . $totalAgendamentos
            . ' agendamento(s) vinculado(s).'
        );
    }

    $sqlParticipante = "
        DELETE FROM participante
        WHERE id_participante = :id
    ";

    $stmtParticipante = $pdo->prepare($sqlParticipante);
    $stmtParticipante->execute([
        ':id' => $id
    ]);

    $pdo->commit();

    header('Location: participantes.php?excluido=1');
    exit;

} catch (PDOException $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log($e->getMessage());

    if ($e->getCode() === '23000') {
        exit(
            'Não foi possível excluir o participante. '
            . 'Existem registros relacionados a ele no sistema.'
        );
    }

    exit('Não foi possível excluir o participante.');
}