
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
    header("Location: clientes.php");
    exit;
}

$idCliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
$nome = trim($_POST['nome'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');

$cpfInformado = trim($_POST['cpf'] ?? '');
$cpf = preg_replace('/\D/', '', $cpfInformado);

if (
    !$idCliente ||
    $nome === '' ||
    $telefone === '' ||
    $endereco === '' ||
    mb_strlen($nome) > 100 ||
    mb_strlen($telefone) > 20 ||
    mb_strlen($endereco) > 200
) {
    exit("Dados inválidos. Confira o formulário.");
}

// Verificar se o cliente existe
$stmt = $pdo->prepare(
    "SELECT id_cliente FROM clientes WHERE id_cliente = :id"
);
$stmt->execute([':id' => $idCliente]);

if (!$stmt->fetch()) {
    exit("Cliente não encontrado.");
}

// Se o CPF foi preenchido, validar e atualizar o hash
if ($cpfInformado !== '') {
    if (strlen($cpf) !== 11) {
        exit("O CPF deve conter 11 dígitos.");
    }

    $cpfHash = hash('sha256', $cpf);

    // Verificar se outro cliente possui esse CPF
    $sql = "SELECT id_cliente
            FROM clientes
            WHERE cpf_hash = :cpf_hash
              AND id_cliente <> :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cpf_hash' => $cpfHash,
        ':id' => $idCliente
    ]);

    if ($stmt->fetch()) {
        exit("Esse CPF já pertence a outro cliente.");
    }

    $sql = "UPDATE clientes
            SET nome = :nome,
                telefone = :telefone,
                endereco = :endereco,
                cpf_hash = :cpf_hash
            WHERE id_cliente = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':endereco' => $endereco,
        ':cpf_hash' => $cpfHash,
        ':id' => $idCliente
    ]);
} else {
    // Atualizar os demais dados sem alterar o CPF
    $sql = "UPDATE clientes
            SET nome = :nome,
                telefone = :telefone,
                endereco = :endereco
            WHERE id_cliente = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':endereco' => $endereco,
        ':id' => $idCliente
    ]);
}

header("Location: clientes.php?atualizado=1");
exit;
