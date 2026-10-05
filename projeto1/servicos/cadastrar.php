<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: cadastrar.php");
    exit;
}

require "../conexao/conexao.php";

$numero_os = $_POST['numero_os'];
$id_cliente = $_POST['id_cliente'];
$id_equipamento = $_POST['id_equipamento'];
$id_tecnico = $_POST['id_tecnico'];
$problema_relatado = $_POST['problema_relatado'];
$diagnostico = $_POST['diagnostico'];
$servico_realizado = $_POST['servico_realizado'];
$status = $_POST['status'];
$prioridade = $_POST['prioridade'];
$valor_estimado = $_POST['valor_estimado'];
$valor_final = $_POST['valor_final'];
$forma_pagamento = $_POST['forma_pagamento'];
$observacoes = $_POST['observacoes'];

$sql = "INSERT INTO ordens_servico (
    numero_os,
    id_cliente,
    id_equipamento,
    id_tecnico,
    problema_relatado,
    diagnostico,
    servico_realizado,
    status,
    prioridade,
    valor_estimado,
    valor_final,
    forma_pagamento,
    observacoes
) VALUES (
    :numero_os,
    :id_cliente,
    :id_equipamento,
    :id_tecnico,
    :problema_relatado,
    :diagnostico,
    :servico_realizado,
    :status,
    :prioridade,
    :valor_estimado,
    :valor_final,
    :forma_pagamento,
    :observacoes
)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":numero_os" => $numero_os,
    ":id_cliente" => $id_cliente,
    ":id_equipamento" => $id_equipamento,
    ":id_tecnico" => $id_tecnico,
    ":problema_relatado" => $problema_relatado,
    ":diagnostico" => $diagnostico,
    ":servico_realizado" => $servico_realizado,
    ":status" => $status,
    ":prioridade" => $prioridade,
    ":valor_estimado" => $valor_estimado,
    ":valor_final" => $valor_final,
    ":forma_pagamento" => $forma_pagamento,
    ":observacoes" => $observacoes
]);

header("Location: index.php");
exit;