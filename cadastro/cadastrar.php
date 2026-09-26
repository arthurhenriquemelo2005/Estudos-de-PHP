<?php 


require "conexao.php";

$nome = $_POST["nome"];
$cpf = $_POST["cpf"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$cidade = $_POST["cidade"];

$sql = "INSERT INTO usuarios (nome,cpf,email,telefone,cidade)
VALUES ('$nome', '$cpf', '$email', '$telefone', '$cidade')";

$conexao->query($sql);

?>