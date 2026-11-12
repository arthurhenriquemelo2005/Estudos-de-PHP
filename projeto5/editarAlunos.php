
<?php

require_once 'conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    die("ID inválido.");
}

// Buscar aluno
$stmt = $pdo->prepare("SELECT * FROM alunos WHERE id = :id");
$stmt->execute([':id' => $id]);

$aluno = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$aluno) {
    die("Aluno não encontrado.");
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $idade = filter_var($_POST['idade'] ?? '', FILTER_VALIDATE_INT);
    $curso = trim($_POST['curso'] ?? '');

    if (
        $nome === '' || mb_strlen($nome) > 100 ||
        !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 150 ||
        $idade === false || $idade < 5 || $idade > 120 ||
        $curso === '' || mb_strlen($curso) > 100
    ) {
        $erro = "Verifique os dados informados.";
    } else {

        try {
            $sql = "UPDATE alunos
                    SET nome = :nome,
                        email = :email,
                        idade = :idade,
                        curso = :curso
                    WHERE id = :id";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':idade' => $idade,
                ':curso' => $curso,
                ':id' => $id
            ]);

            header("Location: listarAlunos.php");
            exit;

        } catch (PDOException $e) {
            $erro = "Não foi possível atualizar. Verifique se o e-mail já está cadastrado.";
        }
    }

    // Manter os dados digitados no formulário
    $aluno['nome'] = $nome;
    $aluno['email'] = $email;
    $aluno['idade'] = $_POST['idade'] ?? '';
    $aluno['curso'] = $curso;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Aluno</title>
</head>
<body>

    <h1>Editar Aluno</h1>

    <?php if ($erro): ?>
        <p><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form method="POST">

        <label>Nome:</label>
        <input type="text" name="nome"
               value="<?= htmlspecialchars($aluno['nome']) ?>" required>

        <br><br>

        <label>Email:</label>
        <input type="email" name="email"
               value="<?= htmlspecialchars($aluno['email']) ?>" required>

        <br><br>

        <label>Idade:</label>
        <input type="number" name="idade"
               value="<?= htmlspecialchars((string)$aluno['idade']) ?>"
               min="5" max="120" required>

        <br><br>

        <label>Curso:</label>
        <input type="text" name="curso"
               value="<?= htmlspecialchars($aluno['curso']) ?>" required>

        <br><br>

        <button type="submit">Salvar alterações</button>

    </form>

    <br>
    <a href="listarAlunos.php">Voltar</a>

</body>
</html>
