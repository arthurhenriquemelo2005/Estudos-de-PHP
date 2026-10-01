<?php
// Logout seguro: limpa sessão, cookie e destrói a sessão
session_start();

// Limpa variáveis de sessão
$_SESSION = [];

// Remove cookie de sessão se existir
if (ini_get('session.use_cookies')) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000,
		$params['path'], $params['domain'],
		$params['secure'], $params['httponly']
	);
}

// Destrói sessão
session_destroy();

// Redireciona para login
header('Location: login.php');
exit;

?>
