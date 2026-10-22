
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if (($_SESSION['usuario_perfil'] ?? '') !== 'ADMIN') {
    http_response_code(403);
    exit("Acesso negado. Apenas administradores podem acessar esta área.");
}

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: pedidos.php");
    exit;
}

$idPedido = filter_input(INPUT_POST, 'id_pedido', FILTER_VALIDATE_INT);
$idCliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
$idPizza = filter_input(INPUT_POST, 'id_pizza', FILTER_VALIDATE_INT);

$dataPedido = $_POST['data_pedido'] ?? '';
$dataEntrega = $_POST['data_entrega'] ?? '';
$status = $_POST['status'] ?? '';

require_once 'status_pedido.php';
$statusValidos = obterStatusPermitidos($pdo);

if (
    !$idPedido ||
    !$idCliente ||
    !$idPizza ||
    $dataPedido === '' ||
    $dataEntrega === '' ||
    !in_array($status, $statusValidos, true)
) {
    exit("Dados inválidos. Volte e confira o formulário.");
}

// Validar formato das datas
$dataPedidoObj = DateTime::createFromFormat(
    '!Y-m-d\TH:i',
    $dataPedido
);

$dataEntregaObj = DateTime::createFromFormat(
    '!Y-m-d\TH:i',
    $dataEntrega
);

if (
    !$dataPedidoObj ||
    $dataPedidoObj->format('Y-m-d\TH:i') !== $dataPedido ||
    !$dataEntregaObj ||
    $dataEntregaObj->format('Y-m-d\TH:i') !== $dataEntrega
) {
    exit("Informe datas válidas.");
}

if ($dataEntregaObj < $dataPedidoObj) {
    exit("A data de entrega não pode ser anterior à data do pedido.");
}

// Verificar se o pedido existe
$stmt = $pdo->prepare(
    "SELECT id_pedido FROM pedidos WHERE id_pedido = :id"
);
$stmt->execute([':id' => $idPedido]);

if (!$stmt->fetch()) {
    exit("Pedido não encontrado.");
}

// Verificar se o cliente existe
$stmt = $pdo->prepare(
    "SELECT id_cliente FROM clientes WHERE id_cliente = :id"
);
$stmt->execute([':id' => $idCliente]);

if (!$stmt->fetch()) {
    exit("Cliente não encontrado.");
}

// Verificar se a pizza existe
$stmt = $pdo->prepare(
    "SELECT id_pizza FROM pizzas WHERE id_pizza = :id"
);
$stmt->execute([':id' => $idPizza]);

if (!$stmt->fetch()) {
    exit("Pizza não encontrada.");
}

// Atualizar pedido
$sql = "UPDATE pedidos
        SET id_cliente = :id_cliente,
            id_pizza = :id_pizza,
            data_pedido = :data_pedido,
            data_entrega = :data_entrega,
            status = :status
        WHERE id_pedido = :id_pedido";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id_cliente' => $idCliente,
    ':id_pizza' => $idPizza,
    ':data_pedido' => $dataPedidoObj->format('Y-m-d H:i:s'),
    ':data_entrega' => $dataEntregaObj->format('Y-m-d H:i:s'),
    ':status' => $status,
    ':id_pedido' => $idPedido
]);

header("Location: pedidos.php?pedido_atualizado=1");
exit;
