<?php
session_start();
require "conexao.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');

if (empty($email) || empty($senha)) {
    die("Todos os campos devem ser preenchidos. <a href='login.php'>Voltar</a>");
}

$sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([":email" => $email]);
$usuario = $stmt->fetch();

if ($usuario && password_verify($senha, $usuario['senha'])) {
    // Previne fixation: gera novo id de sessão
    session_regenerate_id(true);

    $_SESSION['usuario_id']    = $usuario['id'];
    $_SESSION['usuario_nome']  = $usuario['nome'];
    $_SESSION['usuario_email'] = $usuario['email'];
    $_SESSION['logado_em'] = time();

    // Redireciona para o painel restrito
    header("Location: painel.php");
    exit;
} else {
    echo "E-mail ou senha inválidos. <a href='login.php'>Tentar novamente</a>";
}
?>