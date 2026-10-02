<?php 

    //Criando usuário para testar o sistema

    require "../conexao/conexao.php";

    $nome = "Arthur";
    $email = "arthur@gmail.com";
    $senha = password_hash("123", PASSWORD_DEFAULT);
    $telefone = "81998393212";
    $perfil = "ADMIN";

    $sql = "INSERT INTO usuarios (nome,email,senha,telefone,perfil)
            VALUES(:nome,:email,:senha,:telefone,:perfil)";

    
$stmt = $pdo -> prepare($sql);

$stmt -> execute([
    
    ":nome" => $nome,
    ":email" => $email,
    ":senha" => $senha,
    ":telefone" => $telefone,
    ":perfil" => $perfil
]);

echo "Usuario criado com sucesso";


?>