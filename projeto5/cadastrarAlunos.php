<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome  = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $idade = filter_var($_POST['idade'] ?? '', FILTER_VALIDATE_INT);
    $curso = trim($_POST['curso'] ?? '');

    $erros = [];

    if ($nome === '' || mb_strlen($nome) > 100) {
        $erros[] = 'Informe um nome de até 100 caracteres.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150) {
        $erros[] = 'Informe um e-mail válido de até 150 caracteres.';
    }
    if ($idade === false || $idade < 5 || $idade > 120) {
        $erros[] = 'A idade deve estar entre 5 e 120.';
    }
    if ($curso === '' || mb_strlen($curso) > 100) {
        $erros[] = 'Selecione um curso.';
    }

    if ($erros) {
        http_response_code(400);
        echo '<h1>Não foi possível cadastrar</h1><ul>';
        foreach ($erros as $erro) {
            echo '<li>' . htmlspecialchars($erro) . '</li>';
        }
        echo '</ul><p><a href="cadastro.html">Voltar ao formulário</a></p>';
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            'INSERT INTO alunos (nome, email, idade, curso)
             VALUES (:nome, :email, :idade, :curso)'
        );
        $stmt->execute([
            ':nome'  => $nome,
            ':email' => $email,
            ':idade' => $idade,
            ':curso' => $curso,
        ]);

        header('Location: listarAlunos.php');
        exit;

    } catch (PDOException $e) {
        if ($e->errorInfo[1] === 1062) {
            echo '<h1>E-mail já cadastrado</h1>';
            echo '<p>Já existe um aluno com esse e-mail.</p>';
        } else {
            echo '<h1>Erro ao cadastrar</h1>';
            echo '<p>Tente novamente em instantes.</p>';
        }
        echo '<p><a href="cadastro.html">Voltar ao formulário</a></p>';
    }

} else {
    // Acesso direto ao arquivo, sem enviar o formulário
    header('Location: telaCadastro.html');
    exit;
}