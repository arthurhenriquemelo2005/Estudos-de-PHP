
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

$nome = trim($_POST['nome'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$endereco = trim($_POST['endereco'] ?? '');

if ($nome === '') {
    $_SESSION['mensagem'] = 'O nome do cliente é obrigatório.';
    header("Location: clientes.php");
    exit;
}

try {
    $sql = "INSERT INTO clientes
            (nome, cpf, email, telefone, endereco)
            VALUES
            (:nome, :cpf, :email, :telefone, :endereco)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':cpf' => $cpf !== '' ? $cpf : null,
        ':email' => $email !== '' ? $email : null,
        ':telefone' => $telefone !== '' ? $telefone : null,
        ':endereco' => $endereco !== '' ? $endereco : null
    ]);

    $_SESSION['mensagem'] = 'Cliente cadastrado com sucesso!';

} catch (PDOException $e) {
    if ($e->getCode() === '23000') {
        $_SESSION['mensagem'] = 'Erro: CPF ou e-mail já cadastrado.';
    } else {
        $_SESSION['mensagem'] = 'Erro ao cadastrar o cliente.';
    }
}

header("Location: clientes.php");
exit;
