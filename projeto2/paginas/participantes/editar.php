
<?php

session_start();

require_once __DIR__ . '/../../conexao/conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login/login.php');
    exit;
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header('Location: participantes.php');
    exit;
}

$sql = "
    SELECT
        p.id_participante,
        p.id_usuario,
        u.nome,
        u.email,
        p.telefone,
        p.endereco,
        p.bairro,
        p.cidade,
        p.estado
    FROM participante p
    INNER JOIN usuario u
        ON u.id_usuario = p.id_usuario
    WHERE p.id_participante = :id
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':id' => $id
]);

$participante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$participante) {
    header('Location: participantes.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar participante | EcoPoint</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link rel="stylesheet" href="style3.css?v=2">
</head>

<body>

    <header class="topbar">

        <a href="../../painel/painel.php" class="brand">
            <span class="brand-mark">E</span>
            <span>EcoPoint</span>
        </a>

        <div class="user-area">

            <a href="participantes.php" class="btn-painel">
                Voltar aos participantes
            </a>

            <a href="../../painel/logout.php" class="btn-sair">
                Sair
            </a>

        </div>

    </header>

    <main class="page-content">

        <section class="page-heading">

            <div>
                <span class="eyebrow">GESTÃO DO SISTEMA</span>

                <h1>Editar participante</h1>

                <p>
                    Atualize as informações cadastrais do participante.
                </p>
            </div>

        </section>

        <section class="form-card">

            <div class="card-heading">

                <div>
                    <h2>Dados do participante</h2>

                    <p>
                        Altere os campos necessários abaixo.
                    </p>
                </div>

            </div>

            <form
                action="atualizar.php?id=<?= (int) $participante['id_participante'] ?>"
                method="POST"
                class="participant-form"
            >

                <input
                    type="hidden"
                    name="id_participante"
                    value="<?= (int) $participante['id_participante'] ?>"
                >

                <div class="form-section">

                    <h3 class="section-title">
                        Informações pessoais
                    </h3>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label for="nome" class="form-label">
                                Nome completo
                            </label>

                            <input
                                type="text"
                                id="nome"
                                name="nome"
                                class="form-control"
                                placeholder="Digite o nome completo"
                                value="<?= htmlspecialchars($participante['nome'], ENT_QUOTES, 'UTF-8') ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="email" class="form-label">
                                E-mail
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control"
                                placeholder="exemplo@email.com"
                                value="<?= htmlspecialchars($participante['email'], ENT_QUOTES, 'UTF-8') ?>"
                                required
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="telefone" class="form-label">
                                Telefone
                            </label>

                            <input
                                type="tel"
                                id="telefone"
                                name="telefone"
                                class="form-control"
                                placeholder="(81) 99999-9999"
                                value="<?= htmlspecialchars($participante['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            >

                        </div>

                    </div>

                </div>

                <div class="form-section">

                    <h3 class="section-title">
                        Endereço
                    </h3>

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label for="endereco" class="form-label">
                                Endereço
                            </label>

                            <input
                                type="text"
                                id="endereco"
                                name="endereco"
                                class="form-control"
                                placeholder="Rua, avenida, número..."
                                value="<?= htmlspecialchars($participante['endereco'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="bairro" class="form-label">
                                Bairro
                            </label>

                            <input
                                type="text"
                                id="bairro"
                                name="bairro"
                                class="form-control"
                                placeholder="Digite o bairro"
                                value="<?= htmlspecialchars($participante['bairro'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="cidade" class="form-label">
                                Cidade
                            </label>

                            <input
                                type="text"
                                id="cidade"
                                name="cidade"
                                class="form-control"
                                placeholder="Digite a cidade"
                                value="<?= htmlspecialchars($participante['cidade'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            >

                        </div>

                        <div class="col-md-6">

                            <label for="estado" class="form-label">
                                Estado (UF)
                            </label>

                            <input
                                type="text"
                                id="estado"
                                name="estado"
                                class="form-control"
                                placeholder="PE"
                                maxlength="2"
                                value="<?= htmlspecialchars($participante['estado'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            >

                        </div>

                    </div>

                </div>

                <div class="form-actions">

                    <a
                        href="participantes.php"
                        class="btn btn-outline-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Salvar alterações
                    </button>

                </div>

            </form>

        </section>

    </main>

</body>

</html>
