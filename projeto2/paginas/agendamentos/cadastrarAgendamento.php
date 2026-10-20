<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login/login.php');
    exit;
}

require_once __DIR__ . '/../../conexao/conexao.php';

date_default_timezone_set('America/Recife');

$hoje = date('Y-m-d');
$erros = [];
$participantes = [];

$valores = [
    'id_participante' => '',
    'endereco_coleta' => '',
    'data_solicitada' => '',
    'faixa_horario' => '',
    'observacoes' => ''
];

$horarios = [
    '08:00-10:00' => '08h às 10h',
    '10:00-12:00' => '10h às 12h',
    '13:00-15:00' => '13h às 15h',
    '15:00-17:00' => '15h às 17h'
];

function e($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

try {
    $sqlParticipantes = "
        SELECT
            p.id_participante,
            u.nome,
            u.email
        FROM participante p
        INNER JOIN usuario u
            ON u.id_usuario = p.id_usuario
        ORDER BY u.nome ASC
    ";

    $stmtParticipantes = $pdo->query($sqlParticipantes);
    $participantes = $stmtParticipantes->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $erros[] = 'Não foi possível carregar os participantes.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valores['id_participante'] = trim($_POST['id_participante'] ?? '');
    $valores['endereco_coleta'] = trim($_POST['endereco_coleta'] ?? '');
    $valores['data_solicitada'] = trim($_POST['data_solicitada'] ?? '');
    $valores['faixa_horario'] = trim($_POST['faixa_horario'] ?? '');
    $valores['observacoes'] = trim($_POST['observacoes'] ?? '');

    $idParticipante = filter_var(
        $valores['id_participante'],
        FILTER_VALIDATE_INT
    );

    if ($idParticipante === false || $idParticipante === null || $idParticipante < 1) {
        $erros[] = 'Selecione um participante válido.';
    } else {
        try {
            $sqlValidarParticipante = "
                SELECT COUNT(*)
                FROM participante
                WHERE id_participante = :id
            ";

            $stmtValidarParticipante = $pdo->prepare($sqlValidarParticipante);
            $stmtValidarParticipante->execute([
                ':id' => $idParticipante
            ]);

            if ((int) $stmtValidarParticipante->fetchColumn() === 0) {
                $erros[] = 'O participante selecionado não existe.';
            }
        } catch (PDOException $e) {
            $erros[] = 'Não foi possível validar o participante.';
        }
    }

    if ($valores['endereco_coleta'] === '') {
        $erros[] = 'O endereço da coleta é obrigatório.';
    } elseif (strlen($valores['endereco_coleta']) > 200) {
        $erros[] = 'O endereço deve ter no máximo 200 caracteres.';
    }

    $data = DateTimeImmutable::createFromFormat(
        '!Y-m-d',
        $valores['data_solicitada']
    );

    if (
        !$data ||
        $data->format('Y-m-d') !== $valores['data_solicitada']
    ) {
        $erros[] = 'Informe uma data válida.';
    } elseif ($valores['data_solicitada'] < $hoje) {
        $erros[] = 'A data da coleta não pode ser anterior a hoje.';
    }

    if (!array_key_exists($valores['faixa_horario'], $horarios)) {
        $erros[] = 'Selecione uma faixa de horário válida.';
    }

    if (empty($erros)) {
        try {
            $sqlInserir = "
                INSERT INTO agendamento (
                    id_participante,
                    endereco_coleta,
                    data_solicitada,
                    faixa_horario,
                    status,
                    observacoes
                ) VALUES (
                    :id_participante,
                    :endereco_coleta,
                    :data_solicitada,
                    :faixa_horario,
                    'PENDENTE',
                    :observacoes
                )
            ";

            $stmtInserir = $pdo->prepare($sqlInserir);

            $stmtInserir->execute([
                ':id_participante' => $idParticipante,
                ':endereco_coleta' => $valores['endereco_coleta'],
                ':data_solicitada' => $valores['data_solicitada'],
                ':faixa_horario' => $valores['faixa_horario'],
                ':observacoes' => $valores['observacoes'] !== ''
                    ? $valores['observacoes']
                    : null
            ]);

            header('Location: agendamentos.php?sucesso=1');
            exit;

        } catch (PDOException $e) {
            $erros[] = 'Não foi possível salvar o agendamento. Tente novamente.';
        }
    }
}