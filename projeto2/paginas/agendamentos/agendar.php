<?php

$busca = trim($_GET['busca'] ?? '');
$status = $_GET['status'] ?? '';

$agendamentos = [];

$sql = "
    SELECT
        a.id_agendamento,
        a.id_participante,
        a.endereco_coleta,
        a.data_solicitada,
        a.faixa_horario,
        a.status,
        a.observacoes,
        u.nome AS nome_participante,
        u.email AS email_participante
    FROM agendamento AS a
    INNER JOIN participante AS p
        ON p.id_participante = a.id_participante
    INNER JOIN usuario AS u
        ON u.id_usuario = p.id_usuario
    WHERE 1 = 1
";

$params = [];

if ($busca !== '') {
    $sql .= "
        AND (
            u.nome LIKE :nome
            OR u.email LIKE :email
            OR a.endereco_coleta LIKE :endereco
        )
    ";

    $termo = "%{$busca}%";

    $params[':nome'] = $termo;
    $params[':email'] = $termo;
    $params[':endereco'] = $termo;
}

$statusPermitidos = [
    'PENDENTE',
    'CONFIRMADO',
    'EM_ANDAMENTO',
    'CONCLUIDO',
    'CANCELADO'
];

if (in_array($status, $statusPermitidos, true)) {
    $sql .= " AND a.status = :status";
    $params[':status'] = $status;
}

$sql .= " ORDER BY a.data_solicitada DESC, a.id_agendamento DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);