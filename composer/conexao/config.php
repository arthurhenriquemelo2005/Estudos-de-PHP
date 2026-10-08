<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

$db_host = 'localhost';
$db_name = 'cloud';
$db_user = 'root';
$db_pass = 'admin';

try {
    $pdo = new PDO(
        "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4",
        $db_user,
        $db_pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

$client = new Google\Client();
$client->setClientId('753876278891-hlmp809cekfqhru1v1htvuftk7g8lvvb.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost/composer/callback.php');

$client->addScope('email');
$client->addScope('openid');


echo "Foi";
?>