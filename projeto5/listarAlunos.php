
<?php

require_once 'conexao.php';

$sql = "SELECT * FROM alunos ORDER BY nome ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Alunos</title>
</head>
<body>

    <h1>Alunos Cadastrados</h1>

    <?php if (count($alunos) > 0): ?>

        <table border="1" cellpadding="10">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Idade</th>
                    <th>Curso</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($alunos as $aluno): ?>

                    <tr>
                        <td><?= htmlspecialchars($aluno['id']) ?></td>
                        <td><?= htmlspecialchars($aluno['nome']) ?></td>
                        <td><?= htmlspecialchars($aluno['email']) ?></td>
                        <td><?= htmlspecialchars($aluno['idade']) ?></td>
                        <td><?= htmlspecialchars($aluno['curso']) ?></td>

                        <td>
                            <a href="editarAlunos.php?id=<?= $aluno['id'] ?>">
                                Editar
                            </a>

                            <form action="deletarAlunos.php" method="POST"
                                  onsubmit="return confirm('Deseja excluir este aluno?');">

                                <input type="hidden" name="id"
                                       value="<?= $aluno['id'] ?>">

                                <button type="submit">Excluir</button>

                            </form>
                        </td>
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php else: ?>

        <p>Nenhum aluno cadastrado.</p>

    <?php endif; ?>

    <br>
    <a href="telaCadastro.html">Cadastrar novo aluno</a>

</body>
</html>
