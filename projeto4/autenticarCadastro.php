<?php 

require_once 'conexao.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmarSenha = $_POST['confirmarSenha'];

$erro = [];


if($nome === ''){
    $erro[] = 'Nome é obrigatório';
}

if($telefone === ''){
    $erro[] = 'Telefone é obrigatório';
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $erro[] = "E-mail inválido";
}

if(strlen($senha) < 6){
    $erro[] = 'A senha deve ter no minimo 6 caracter';
}

if($senha !== $confirmarSenha){
    $erro[] = 'As senhas devem ser iguais';
}

if(empty($erro)){
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    
    $sql = "INSERT INTO clientes (nome, telefone, email, senha)
    VALUES (:nome, :telefone, :email, :senha)";
    $stmt = $pdo -> prepare($sql);

    $stmt->execute([
    ":nome" => $nome,
    ":telefone" => $telefone,
    ":email" => $email,
    ":senha" => $senhaHash
]);
}
}

?>