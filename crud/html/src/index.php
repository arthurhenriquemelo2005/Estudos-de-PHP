<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];

    echo "Cadastro realizado com sucesso!";
    echo "<br>Nome: " . $nome;
    echo "<br>E-mail: " . $email;
}

?>