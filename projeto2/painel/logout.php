<?php

session_start();

// Limpa todas as variáveis da sessão
$_SESSION = [];

// Encerra a sessão no navegador
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Destrói a sessão no servidor
session_destroy();

// Volta para a tela de login
header('Location: ../login/login.php');
exit;