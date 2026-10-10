<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: ./telaCadastro/cadastro.php');
exit;
