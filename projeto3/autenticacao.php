
<?php
session_start();

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

$token = $_POST['csrf_token'] ?? '';
$tokenSessao = $_SESSION['csrf_token'] ?? '';

if (
    !is_string($token) ||
    !is_string($tokenSessao) ||
    $token === '' ||
    !hash_equals($tokenSessao, $token)
) {
    $_SESSION['erro_login'] = 'Sessão expirada. Tente novamente.';
    header('Location: login.php');
    exit;
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!is_string($senha) || $email === '' || $senha === '') {
    $_SESSION['erro_login'] = 'Preencha o e-mail e a senha.';
    header('Location: login.php');
    exit;
}

$sql = "SELECT id_usuario, nome, email, senha_hash, perfil, ativo
        FROM usuarios
        WHERE email = :email
        LIMIT 1";

$stmt = $pdo->prepare($sql);
$stmt->execute(['email' => $email]);

$usuario = $stmt->fetch();

if (
    !$usuario ||
    (int) $usuario['ativo'] !== 1 ||
    !password_verify($senha, $usuario['senha_hash'])
) {
    $_SESSION['erro_login'] = 'E-mail ou senha inválidos.';
    header('Location: login.php');
    exit;
}

session_regenerate_id(true);

$_SESSION['id_usuario'] = $usuario['id_usuario'];
$_SESSION['usuario_nome'] = $usuario['nome'];
$_SESSION['usuario_perfil'] = $usuario['perfil'];
$_SESSION['ultimo_acesso'] = time();

unset($_SESSION['csrf_token']);

header('Location: painel.php');
exit;
