
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
</head>

<body>

    <h1>Nova Encomenda</h1>

    <p>
        Olá,
        <strong>
            <?= htmlspecialchars($cliente['nome']) ?>
        </strong>
    </p>

    <p>
        Telefone:
        <?= htmlspecialchars($cliente['telefone']) ?>
    </p>

    <p>
        Seus Doce Pontos:
        <strong>
            <?= (int) $cliente['doce_pontos'] ?>
        </strong>
    </p>

    <hr>

    <form action="processar_encomenda.php" method="POST">

        <h2>Dados da encomenda</h2>

        <label for="data_retirada">Data de retirada:</label>

        <input
            type="date"
            name="data_retirada"
            id="data_retirada"
            min="<?= date('Y-m-d') ?>"
            required
        >

        <hr>

        <h2>Itens da encomenda</h2>

        <div id="container-itens">

            <div class="item">

                <label>Produto:</label>

                <select name="itens[0][categoria]" required>

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

                <br><br>

                <label>Quantidade:</label>

                <input
                    type="number"
                    name="itens[0][quantidade]"
                    min="0.01"
                    step="0.01"
                    placeholder="Informe a quantidade"
                    required
                >

            </div>

        </div>

        <br>

        <button type="button" id="adicionar-item">
            Adicionar outro produto
        </button>

        <hr>

        <h2>Cupom de desconto</h2>

        <p>
            Escolha um cupom para utilizar seus Doce Pontos.
        </p>

        <select name="id_cupom">

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

        <hr>

        <h2>Observações</h2>

        <textarea
            name="observacoes"
            rows="4"
            cols="40"
            placeholder="Alguma observação sobre sua encomenda?"
        ></textarea>

        <br><br>

        <button type="submit">
            Enviar encomenda
        </button>

    </form>

    <script>

        let contador = 1;

        const container = document.getElementById('container-itens');

        const botaoAdicionar = document.getElementById('adicionar-item');

        botaoAdicionar.addEventListener('click', function () {

            const novoItem = document.createElement('div');

            novoItem.classList.add('item');

            novoItem.innerHTML = `
                <hr>

                <label>Produto:</label>

                <select name="itens[${contador}][categoria]" required>

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

                <br><br>

                <label>Quantidade:</label>

                <input
                    type="number"
                    name="itens[${contador}][quantidade]"
                    min="0.01"
                    step="0.01"
                    placeholder="Informe a quantidade"
                    required
                >

                <br><br>

                <button type="button" class="remover-item">
                    Remover produto
                </button>

            `;

            container.appendChild(novoItem);

            contador++;

        });

        container.addEventListener('click', function (event) {

            if (event.target.classList.contains('remover-item')) {

                event.target.closest('.item').remove();

            }

        });

    </script>

</body>

</html>
