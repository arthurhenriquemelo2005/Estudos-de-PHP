<?php 

    session_start();
    require_once __DIR__ . "/../../conexao/conexao.php";

    if(!isset($_SESSION['usuario_id'])){
        header("Location: ../../login/login.php");
        exit;
    }

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT );
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];


        try {

        $pdo->beginTransaction();

        $sql = "INSERT INTO usuario (
            nome,
            email,
            senha_hash,
            perfil
        ) VALUES (
            :nome,
            :email,
            :senha_hash,
            :perfil
        )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":nome" => $nome,
            ":email" => $email,
            ":senha_hash" => $senha,
            ":perfil" => "PARTICIPANTE"
        ]);

        $id_usuario = $pdo->lastInsertId();

        $sql = "INSERT INTO participante (
            id_usuario,
            telefone,
            endereco,
            bairro,
            cidade,
            estado
        ) VALUES (
            :id_usuario,
            :telefone,
            :endereco,
            :bairro,
            :cidade,
            :estado
        )";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":id_usuario" => $id_usuario,
            ":telefone" => $telefone,
            ":endereco" => $endereco,
            ":bairro" => $bairro,
            ":cidade" => $cidade,
            ":estado" => $estado
        ]);

        $pdo->commit();

        header("Location: participantes.php");
        exit;

    } catch (PDOException $e) {

        $pdo->rollBack();

        echo "Erro ao cadastrar participante.";
    }

?>
