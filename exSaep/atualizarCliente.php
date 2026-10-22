
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: clientes.php");
    exit;
}

$id = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');

if (!$id || $nome === '') {
    $_SESSION['mensagem'] = 'Informe um ID válido e o nome do cliente.';
    header("Location: clientes.php");
    exit;
}

try {
    $sql = "UPDATE clientes
            SET nome = :nome,
                cpf = :cpf,
                email = :email,
                telefone = :telefone,
                endereco = :endereco
            WHERE id_cliente = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':cpf' => $cpf !== '' ? $cpf : null,
        ':email' => $email !== '' ? $email : null,
        ':telefone' => $telefone !== '' ? $telefone : null,
        ':endereco' => $endereco !== '' ? $endereco : null,
        ':id' => $id
    ]);

    $_SESSION['mensagem'] = 'Cliente atualizado com sucesso!';

} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        $_SESSION['mensagem'] = 'Erro: CPF ou e-mail já pertence a outro cadastro.';
    } else {
        $_SESSION['mensagem'] = 'Erro ao atualizar o cliente.';
    }
}

header("Location: clientes.php");
exit;
