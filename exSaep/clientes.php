<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

$sql = "SELECT * FROM clientes ORDER BY id_cliente DESC";
$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll();

$busca = trim($_GET['busca'] ?? '');
if ($busca !== '') {

    $sql = "SELECT * FROM clientes
            WHERE nome LIKE :nome
               OR cpf LIKE :cpf
               OR email LIKE :email
            ORDER BY id_cliente DESC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => "%$busca%",
        ':cpf' => "%$busca%",
        ':email' => "%$busca%"
    ]);

} else {

    
    $sql = "SELECT * FROM clientes
            ORDER BY id_cliente DESC";

    $stmt = $pdo->query($sql);
}
function e($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$clientes = $stmt ->fetchAll();

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes | Locadora</title>

</head>
<body>

<header class="topbar">
    <div>
        <a href="painel.php" class="voltar">← Voltar ao painel</a>
        <h1>Clientes</h1>
        <p>Gerencie os clientes cadastrados na locadora.</p>
    </div>

    <span class="usuario">
        <?= e($_SESSION['nome'] ?? 'Usuário') ?>
    </span>
</header>

<main class="container">

    <?php if ($mensagem): ?>
        <div class="mensagem">
            <?= e($mensagem) ?>
        </div>
    <?php endif; ?>

    <section class="card">
        <div class="card-header">
            <h2>Novo cliente</h2>
            <p>Preencha os dados para cadastrar um cliente.</p>
        </div>

        <form action="salvarCliente.php" method="POST">
            <div class="form-grid">

                <div class="campo campo-largo">
                    <label for="nome">Nome completo     </label>
                    <input type="text" id="nome" name="nome"
                           maxlength="100" required>
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf"
                           maxlength="14" placeholder="000.000.000-00">
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone"
                           maxlength="20" placeholder="(00) 00000-0000">
                </div>

                <div class="campo campo-largo">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email"
                           maxlength="150">
                </div>

                <div class="campo campo-largo">
                    <label for="endereco">Endereço</label>
                    <input type="text" id="endereco" name="endereco"
                           maxlength="255">
                </div>

            </div>

            <button type="submit" class="btn-principal">
                Cadastrar cliente
            </button>
        </form>
    </section>

    <section>
        <form action="clientes.php" method="GET" class="busca-form">
    <input
        type="search"
        name="busca"
        placeholder="Buscar por nome, CPF ou e-mail..."
        value="<?= e($busca) ?>"
    >

    <button type="submit" class="btn-principal">
        Buscar
    </button>

    <?php if ($busca !== ''): ?>
        <a href="clientes.php" class="btn-editar">
            Limpar busca
        </a>
    <?php endif; ?>
</form>
    </section>
    <section class="card">
        <div class="card-header lista-header">
            <div>
                <p>
                    <?= count($clientes)  ?> reigistro(s) encontrado(s)
                    <?php if ($busca !== ''): ?>
                    Buscar por: "<?= e($busca)  ?>"
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <div class="tabela-container">
            <table>
                <thead>
                    <tr>

                        <th>Nome</th>
                        <th>CPF</th>
                        <th>E-mail</th>
                        <th>Telefone</th>
                        <th>Ações</th>

                    </tr>
                </thead>

                <tbody>
                <?php if (empty($clientes)): ?>
                    <tr>
                        <td colspan="6" class="vazio">
                            Nenhum cliente cadastrado.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                           
                            <td><?= e($cliente['nome']) ?></td>
                            <td><?= e($cliente['cpf'] ?? '-') ?></td>
                            <td><?= e($cliente['email'] ?? '-') ?></td>
                            <td><?= e($cliente['telefone'] ?? '-') ?></td>
                            <td class="acoes">
                                
                                <a class="btn-editar"
                                   href="editar.php?id=<?= (int) $cliente['id_cliente'] ?>">
                                    Editar
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

</main>

</body>
</html>
