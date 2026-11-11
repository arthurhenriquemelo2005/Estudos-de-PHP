
<?php

session_start();

require_once 'conexao.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

// Função para proteger a exibição dos dados
function escapar($valor)
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

try {

    // Busca todas as encomendas
    $sql = "SELECT
                id_encomenda,
                id_cliente,
                nome_cliente,
                telefone_contato,
                data_retirada,
                valor_bruto,
                percentual_urgencia,
                valor_taxa_urgencia,
                valor_desconto,
                valor_liquido,
                pontos_gerados,
                status,
                observacoes,
                criado_em
            FROM encomendas
            ORDER BY criado_em DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $encomendas = $stmt->fetchAll();

    // Prepara a consulta dos itens
    $sqlItens = "SELECT
                    nome_categoria,
                    unidade_medida,
                    quantidade,
                    preco_unitario,
                    subtotal
                 FROM itens_encomenda
                 WHERE id_encomenda = :id";

    $stmtItens = $pdo->prepare($sqlItens);

} catch (PDOException $e) {

    error_log($e->getMessage());

    die('Não foi possível carregar as encomendas.');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encomendas - Doce Encanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilo-doce.css">
</head>

<body>
    <div class="page-shell">
        <div class="container">
            <div class="doce-card p-4 p-lg-5">
                <header class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                    <div>
                        <div class="doce-brand">Doce Encanto</div>
                        <h1 class="title-doce mb-1">Gerenciamento de encomendas</h1>
                        <p class="mb-0 text-doce-muted">
                            Bem-vindo,
                            <?= escapar($_SESSION['usuario_nome'] ?? 'Usuário') ?>!
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="cadastrarEncomenda.php" class="btn btn-doce-secondary">Voltar ao painel</a>
                        <a href="logout.php" class="btn btn-doce-soft">Sair</a>
                    </div>
                </header>

                <main>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-2">
                        <h2 class="title-doce h3 mb-0">Todas as encomendas</h2>
                        <span class="badge-doce">Total de encomendas: <strong><?= count($encomendas) ?></strong></span>
                    </div>

                    <?php if (count($encomendas) === 0): ?>

                        <div class="alert alert-doce">Nenhuma encomenda foi registrada ainda.</div>

                    <?php else: ?>

                        <?php foreach ($encomendas as $encomenda): ?>

                            <section class="summary-box mb-4">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                                    <h3 class="title-doce h4 mb-0">
                                        Encomenda #<?= (int) $encomenda['id_encomenda'] ?>
                                    </h3>
                                    <span class="badge-doce badge-doce-pink"><?= escapar($encomenda['status']) ?></span>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-4">
                                        <p class="mb-1 text-doce-muted">Nome</p>
                                        <strong><?= escapar($encomenda['nome_cliente']) ?></strong>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p class="mb-1 text-doce-muted">Telefone</p>
                                        <strong><?= escapar($encomenda['telefone_contato']) ?></strong>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p class="mb-1 text-doce-muted">ID do cliente</p>
                                        <strong><?= (int) $encomenda['id_cliente'] ?></strong>
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-12 col-md-4">
                                        <p class="mb-1 text-doce-muted">Data de retirada</p>
                                        <strong><?= escapar(date('d/m/Y', strtotime($encomenda['data_retirada'])) ) ?></strong>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <p class="mb-1 text-doce-muted">Registrada em</p>
                                        <strong><?= escapar($encomenda['criado_em']) ?></strong>
                                    </div>
                                </div>

                                <h4 class="title-doce h5 mt-4">Produtos solicitados</h4>

                                <?php

                                $stmtItens->execute([
                                    ':id' => $encomenda['id_encomenda']
                                ]);

                                $itens = $stmtItens->fetchAll();

                                ?>

                                <?php if (count($itens) > 0): ?>

                                    <div class="table-responsive mt-3">
                                        <table class="table table-doce align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Produto</th>
                                                    <th>Quantidade</th>
                                                    <th>Unidade</th>
                                                    <th>Preço unitário</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($itens as $item): ?>
                                                    <tr>
                                                        <td><?= escapar($item['nome_categoria']) ?></td>
                                                        <td><?= escapar($item['quantidade']) ?></td>
                                                        <td><?= escapar($item['unidade_medida']) ?></td>
                                                        <td>R$ <?= number_format($item['preco_unitario'], 2, ',', '.') ?></td>
                                                        <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>

                                <?php else: ?>

                                    <p class="text-doce-muted mb-0">Esta encomenda não possui itens registrados.</p>

                                <?php endif; ?>

                                <h4 class="title-doce h5 mt-4">Resumo financeiro</h4>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <p class="mb-1 text-doce-muted">Valor bruto</p>
                                        <strong>R$ <?= number_format($encomenda['valor_bruto'], 2, ',', '.') ?></strong>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <p class="mb-1 text-doce-muted">Taxa de urgência</p>
                                        <strong>R$ <?= number_format($encomenda['valor_taxa_urgencia'], 2, ',', '.') ?></strong>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <p class="mb-1 text-doce-muted">Desconto</p>
                                        <strong>R$ <?= number_format($encomenda['valor_desconto'], 2, ',', '.') ?></strong>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <p class="mb-1 text-doce-muted">Valor líquido</p>
                                        <strong class="fs-5">R$ <?= number_format($encomenda['valor_liquido'], 2, ',', '.') ?></strong>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <p class="mb-1 text-doce-muted">Doce Pontos</p>
                                        <strong><?= (int) $encomenda['pontos_gerados'] ?></strong>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <p class="mb-1 text-doce-muted">Observações</p>
                                        <strong><?= escapar($encomenda['observacoes'] ?? 'Nenhuma') ?></strong>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-4">
                                    <a href="editarEncomenda.php?id=<?= $encomenda['id_encomenda'] ?>" class="btn btn-doce-secondary">Editar</a>

                                    <form action="deletarEncomenda.php" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta encomenda?');" class="m-0">
                                        <input type="hidden" name="id_encomenda" value="<?= $encomenda['id_encomenda'] ?>">
                                        <button type="submit" name="deletar" class="btn btn-doce-danger">Deletar</button>
                                    </form>
                                </div>
                            </section>

                        <?php endforeach; ?>

                    <?php endif; ?>
                </main>
            </div>
        </div>
    </div>
</body>

</html>
