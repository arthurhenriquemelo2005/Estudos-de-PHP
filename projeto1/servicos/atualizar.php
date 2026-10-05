<?php

require "../conexao/conexao.php";
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$id = $_POST['id_os'] ?? $_POST['id'] ?? null;

if (!$id) {
    header("Location: index.php");
    exit;
}

require "../conexao/conexao.php";

$numero_os = $_POST['numero_os'];
$id_cliente = $_POST['id_cliente'];
$id_equipamento = $_POST['id_equipamento'];
$id_tecnico = $_POST['id_tecnico'];
$data_previsao = $_POST['data_previsao'] ?: null;
$problema_relatado = $_POST['problema_relatado'];
$diagnostico = $_POST['diagnostico'] ?? null;
$servico_realizado = $_POST['servico_realizado'] ?? null;
$status = $_POST['status'];
$prioridade = $_POST['prioridade'];
$valor_estimado = $_POST['valor_estimado'] ?? null;
$valor_final = $_POST['valor_final'] ?? null;
$forma_pagamento = $_POST['forma_pagamento'] ?? null;
$observacoes = $_POST['observacoes'] ?? null;

$sql = "UPDATE ordens_servico SET
            numero_os = :numero_os,
            id_cliente = :id_cliente,
            id_equipamento = :id_equipamento,
            id_tecnico = :id_tecnico,
            data_previsao = :data_previsao,
            problema_relatado = :problema_relatado,
            diagnostico = :diagnostico,
            servico_realizado = :servico_realizado,
            status = :status,
            prioridade = :prioridade,
            valor_estimado = :valor_estimado,
            valor_final = :valor_final,
            forma_pagamento = :forma_pagamento,
            observacoes = :observacoes
        WHERE id_os = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":numero_os" => $numero_os,
    ":id_cliente" => $id_cliente,
    ":id_equipamento" => $id_equipamento,
    ":id_tecnico" => $id_tecnico,
    ":data_previsao" => $data_previsao,
    ":problema_relatado" => $problema_relatado,
    ":diagnostico" => $diagnostico,
    ":servico_realizado" => $servico_realizado,
    ":status" => $status,
    ":prioridade" => $prioridade,
    ":valor_estimado" => $valor_estimado,
    ":valor_final" => $valor_final,
    ":forma_pagamento" => $forma_pagamento,
    ":observacoes" => $observacoes,
    ":id" => $id
]);

if ($stmt->rowCount() === 0) {
    header("Location: index.php");
    exit;
}

header("Location: index.php");
exit;
