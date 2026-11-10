<?php

session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.html');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($email === '' || $senha === '') {
    $mensagem = urlencode('Preencha e-mail e senha.');
    header('Location: login.html?erro=' . $mensagem);
    exit;
}

try {
    $sql = 'SELECT id_cliente, nome, senha FROM clientes WHERE email = :email LIMIT 1';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch();

    if (!$usuario || !password_verify($senha, $usuario['senha'])) {
        $mensagem = urlencode('E-mail ou senha inválidos.');
        header('Location: login.html?erro=' . $mensagem);
        exit;
    }

    $_SESSION['usuario_id'] = $usuario['id_cliente'];
    $_SESSION['usuario_nome'] = $usuario['nome'];

    header('Location: cadastrarEncomenda.php');
    exit;
} catch (PDOException $e) {
    $mensagem = urlencode('Erro ao tentar fazer login.');
    header('Location: login.html?erro=' . $mensagem);
    exit;
}
