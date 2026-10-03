<?php 

    session_start();

    require "../conexao/conexao.php";
    if(!isset($_SESSION['usuario_id'])){
        header("Location: ../login/login.php");
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location:index.php");
    }

    $id = $_POST['id'];

    $nome = $_POST['nome'];
    $cpf_cnpj = $_POST['cpf_cnpj'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $telefone_secundario = $_POST['telefone_secundario'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $cep = $_POST['cep'];

$sql = "UPDATE clientes SET
    nome = :nome,
    cpf_cnpj = :cpf_cnpj,
    email = :email,
    telefone = :telefone,
    telefone_secundario = :telefone_secundario,
    logradouro = :logradouro,
    numero = :numero,
    bairro = :bairro,
    cidade = :cidade,
    estado = :estado,
    cep = :cep
    WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":nome" => $nome,
    ":cpf_cnpj" => $cpf_cnpj,
    ":email" => $email,
    ":telefone" => $telefone,
    ":telefone_secundario" => $telefone_secundario,
    ":logradouro" => $logradouro,
    ":numero" => $numero,
    ":bairro" => $bairro,
    ":cidade" => $cidade,
    ":estado" => $estado,
    ":cep" => $cep,
    ":id" => $id
]);

header("Location: index.php");
exit;

?>