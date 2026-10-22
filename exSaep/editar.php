
<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

require_once "conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensagem'] = 'ID do cliente inválido.';
    header("Location: clientes.php");
    exit;
}

$sql = "SELECT * FROM clientes WHERE id_cliente = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

$cliente = $stmt->fetch();

if (!$cliente) {
    $_SESSION['mensagem'] = 'Cliente não encontrado.';
    header("Location: clientes.php");
    exit;
}

function e($valor) {
    return htmlspecialchars((string) ($valor ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente | Locadora</title>

</head>
<body>

<header class="topbar">
    <div>
        <a href="clientes.php" class="voltar">← Voltar aos clientes</a>
        <h1>Editar cliente</h1>
        <p>Atualize os dados do cliente selecionado.</p>
    </div>

    <span class="usuario">
        <?= e($_SESSION['nome'] ?? 'Usuário') ?>
    </span>
</header>

<main class="container">

    <section class="card">
        <div class="card-header">
            <h2>Dados do cliente #<?= (int) $cliente['id_cliente'] ?></h2>
            <p>Altere os campos desejados e salve as modificações.</p>
        </div>

        <form action="atualizarCliente.php" method="POST">
            <input
                type="hidden"
                name="id_cliente"
                value="<?= (int) $cliente['id_cliente'] ?>"
            >

            <div class="form-grid">

                <div class="campo campo-largo">
                    <label for="nome">Nome completo</label>
                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        maxlength="100"
                        value="<?= e($cliente['nome']) ?>"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="cpf">CPF</label>
                    <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        maxlength="14"
                        placeholder="000.000.000-00"
                        value="<?= e($cliente['cpf']) ?>"
                    >
                </div>

                <div class="campo">
                    <label for="telefone">Telefone</label>
                    <input
                        type="tel"
                        id="telefone"
                        name="telefone"
                        maxlength="20"
                        placeholder="(00) 00000-0000"
                        value="<?= e($cliente['telefone']) ?>"
                    >
                </div>

                <div class="campo campo-largo">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        maxlength="150"
                        value="<?= e($cliente['email']) ?>"
                    >
                </div>

                <div class="campo campo-largo">
                    <label for="endereco">Endereço</label>
                    <input
                        type="text"
                        id="endereco"
                        name="endereco"
                        maxlength="255"
                        value="<?= e($cliente['endereco']) ?>"
                    >
                </div>

            </div>

            <button type="submit" class="btn-principal">
                Salvar alterações
            </button>

            <a href="clientes.php" class="voltar">Cancelar</a>
        </form>
    </section>

</main>

</body>
</html>
