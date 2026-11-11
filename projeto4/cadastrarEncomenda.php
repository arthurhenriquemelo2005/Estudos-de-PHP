
<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

require_once 'conexao.php';

try {

        $sqlCliente = "SELECT id_cliente, nome, telefone, doce_pontos
                   FROM clientes
                   WHERE id_cliente = :id";

    $stmtCliente = $pdo->prepare($sqlCliente);
    $stmtCliente->bindValue(':id', $_SESSION['usuario_id']);
    $stmtCliente->execute();

    $cliente = $stmtCliente->fetch();

    if (!$cliente) {
        session_destroy();
        header('Location: login.html');
        exit;
    }

    $sqlCategorias = "SELECT id_categoria, nome, grupo,
                             unidade_medida, preco_unitario,
                             quantidade_minima
                      FROM categorias
                      WHERE ativo = 1
                      ORDER BY nome";

    $stmtCategorias = $pdo->query($sqlCategorias);
    $categorias = $stmtCategorias->fetchAll();

    $sqlCupons = "SELECT id_cupom, nome, pontos_necessarios,
                         valor_desconto
                  FROM cupons
                  WHERE ativo = 1
                  ORDER BY pontos_necessarios";

    $stmtCupons = $pdo->query($sqlCupons);
    $cupons = $stmtCupons->fetchAll();

} catch (PDOException $e) {
    die("Erro ao carregar os dados: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Encomenda - Doce Encanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilo-doce.css">
</head>

<body>
    <div class="page-shell">
        <div class="container">
            <div class="doce-card p-4 p-lg-5">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <div class="doce-brand">Doce Encanto</div>
                        <h1 class="title-doce mb-1">Nova Encomenda</h1>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="listarEncomendas.php" class="btn btn-doce-secondary">Ver encomendas</a>
                        <a href="logout.php" class="btn btn-doce-soft">Sair</a>
                    </div>
                </div>

                <div class="doce-panel mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-12 col-md-4">
                            <p class="mb-1 text-doce-muted">Cliente</p>
                            <strong><?= htmlspecialchars($cliente['nome']) ?></strong>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="mb-1 text-doce-muted">Telefone</p>
                            <strong><?= htmlspecialchars($cliente['telefone']) ?></strong>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="mb-1 text-doce-muted">Doce Pontos</p>
                            <span class="badge-doce badge-doce-pink"><?= (int) $cliente['doce_pontos'] ?></span>
                        </div>
                    </div>
                </div>

                <form action="processar_encomenda.php" method="POST" class="row g-3">
                    <div class="col-12">
                        <h2 class="title-doce h4 mb-3">Dados da encomenda</h2>
                    </div>

                    <div class="col-12 col-md-6">
                        <label for="data_retirada" class="form-label">Data de retirada:</label>
                        <input
                            type="date"
                            name="data_retirada"
                            id="data_retirada"
                            class="form-control"
                            min="<?= date('Y-m-d') ?>"
                            required
                        >
                    </div>

                    <div class="col-12 mt-4">
                        <h2 class="title-doce h4 mb-3">Itens da encomenda</h2>
                    </div>

                    <div id="container-itens" class="col-12">
                        <div class="item-doce">
                            <div class="row g-3 align-items-end">
                                <div class="col-12 col-lg-8">
                                    <label class="form-label">Produto:</label>
                                    <select name="itens[0][categoria]" class="form-select" required>
                                        <option value="">Selecione um produto</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= (int) $categoria['id_categoria'] ?>">
                                                <?= htmlspecialchars($categoria['nome']) ?>
                                                -
                                                R$
                                                <?= number_format(
                                                    $categoria['preco_unitario'],
                                                    2,
                                                    ',',
                                                    '.'
                                                ) ?>
                                                /
                                                <?= htmlspecialchars($categoria['unidade_medida']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <label class="form-label">Quantidade:</label>
                                    <input
                                        type="number"
                                        name="itens[0][quantidade]"
                                        class="form-control"
                                        min="0.01"
                                        step="0.01"
                                        placeholder="Informe a quantidade"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="button" id="adicionar-item" class="btn btn-doce-secondary">
                            Adicionar outro produto
                        </button>
                    </div>

                    <div class="col-12 mt-4">
                        <h2 class="title-doce h4 mb-3">Cupom de desconto</h2>
                        <p class="text-doce-muted mb-3">Escolha um cupom para utilizar seus Doce Pontos.</p>
                    </div>

                    <div class="col-12 col-md-8">
                        <select name="id_cupom" class="form-select">
                            <option value="">Não utilizar cupom</option>
                            <?php foreach ($cupons as $cupom): ?>
                                <option value="<?= (int) $cupom['id_cupom'] ?>">
                                    <?= htmlspecialchars($cupom['nome']) ?>
                                    -
                                    <?= (int) $cupom['pontos_necessarios'] ?>
                                    pontos
                                    -
                                    Desconto de R$
                                    <?= number_format(
                                        $cupom['valor_desconto'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 mt-4">
                        <h2 class="title-doce h4 mb-3">Observações</h2>
                    </div>

                    <div class="col-12">
                        <textarea
                            name="observacoes"
                            rows="4"
                            class="form-control"
                            placeholder="Alguma observação sobre sua encomenda?"
                        ></textarea>
                    </div>

                    <div class="col-12 d-flex flex-wrap gap-2 mt-4">
                        <button type="submit" class="btn btn-doce-primary">
                            Enviar encomenda
                        </button>
                        <a href="listarEncomendas.php" class="btn btn-doce-secondary">Ver Encomendas</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let contador = 1;

        const container = document.getElementById('container-itens');

        const botaoAdicionar = document.getElementById('adicionar-item');

        botaoAdicionar.addEventListener('click', function () {

            const novoItem = document.createElement('div');

            novoItem.classList.add('item-doce');

            novoItem.innerHTML = `
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-8">
                        <label class="form-label">Produto:</label>
                        <select name="itens[${contador}][categoria]" class="form-select" required>
                            <option value="">Selecione um produto</option>
                            <?php foreach ($categorias as $categoria): ?>
                                <option value="<?= (int) $categoria['id_categoria'] ?>">
                                    <?= htmlspecialchars($categoria['nome']) ?>
                                    -
                                    R$
                                    <?= number_format(
                                        $categoria['preco_unitario'],
                                        2,
                                        ',',
                                        '.'
                                    ) ?>
                                    /
                                    <?= htmlspecialchars($categoria['unidade_medida']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-12 col-lg-4">
                        <label class="form-label">Quantidade:</label>
                        <input
                            type="number"
                            name="itens[${contador}][quantidade]"
                            class="form-control"
                            min="0.01"
                            step="0.01"
                            placeholder="Informe a quantidade"
                            required
                        >
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-doce-danger remover-item">
                        Remover produto
                    </button>
                </div>
            `;

            container.appendChild(novoItem);

            contador++;

        });

        container.addEventListener('click', function (event) {

            if (event.target.classList.contains('remover-item')) {

                event.target.closest('.item-doce').remove();

            }

        });
    </script>

</body>

</html>
