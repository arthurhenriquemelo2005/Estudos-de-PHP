
<?php

require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

    if (!$id || $id < 1) {
        die("ID inválido.");
    }

    $sql = "DELETE FROM alunos WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':id' => $id
    ]);

    header("Location: listarAlunos.php");
    exit;

} else {

    header("Location: listarAlunos.php");
    exit;

}

