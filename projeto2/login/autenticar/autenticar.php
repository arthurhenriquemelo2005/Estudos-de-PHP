<?php

require_once __DIR__ . '/../../conexao/conexao.php';

session_start();
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email !== '' && $senha !== '') {
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha_hash'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_perfil'] = $usuario['perfil'];

            header('Location: ../../painel/painel.php');
            exit;
        }

        $_SESSION['erro_login'] = 'Email ou senha inválidos.';
        header('Location: ../login.php');
        exit;
    }

    $_SESSION['erro_login'] = 'Preencha email e senha.';
    header('Location: ../login.php');
    exit;
}

?>