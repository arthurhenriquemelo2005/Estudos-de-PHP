
<?php

session_start();

// Limpa todas as variáveis da sessão
$_SESSION = [];

// Destrói a sessão atual
session_destroy();

// Volta para o login
header("Location: login.php");
exit;
