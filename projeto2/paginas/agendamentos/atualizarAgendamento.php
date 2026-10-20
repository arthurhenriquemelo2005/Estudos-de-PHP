<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login/login.php');
    exit;
}

require_once __DIR__ . '/../../conexao/conexao.php';

function e($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id_agendamento', FILTER_VALIDATE_INT);
}

if (!$id || $id < 1) {
    header('Location: agendamentos.php');
    exit;
}

$sql = "
    SELECT
        a.id_agendamento,
        a.endereco_coleta,
        a.data_solicitada,
        a.faixa_horario,
        a.status,
        u.nome AS nome_participante
    FROM agendamento a
    INNER JOIN participante p
        ON p.id_participante = a.id_participante
    INNER JOIN usuario u
        ON u.id_usuario = p.id_usuario
    WHERE a.id_agendamento = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$agendamento) {
    header('Location: agendamentos.php');
    exit;
}

$transicoes = [
    'PENDENTE' => ['CONFIRMADO', 'CANCELADO'],
    'CONFIRMADO' => ['EM_ANDAMENTO'],
    'EM_ANDAMENTO' => ['CONCLUIDO', 'CANCELADO'],
    'CONCLUIDO' => [],
    'CANCELADO' => []
];

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novoStatus = $_POST['status'] ?? '';

    if (!in_array($novoStatus, $transicoes[$agendamento['status']], true)) {
        $erros[] = 'Essa alteração de status não é permitida.';
    } else {
        $sql = "
            UPDATE agendamento
            SET status = ?
            WHERE id_agendamento = ?
              AND status = ?
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $novoStatus,
            $id,
            $agendamento['status']
        ]);

        if ($stmt->rowCount() === 1) {
            header('Location: agendamentos.php?atualizado=1');
            exit;
        }

        $erros[] = 'O status não foi alterado. Atualize a página e tente novamente.';
    }
}

$statusDisponiveis = $transicoes[$agendamento['status']];

?>