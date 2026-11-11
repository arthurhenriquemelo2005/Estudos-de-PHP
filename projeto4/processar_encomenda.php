<?php

session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: cadastrar_encomenda.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT id_cliente, nome, telefone, doce_pontos
                           FROM clientes
                           WHERE id_cliente = :id
                           FOR UPDATE");
    $stmt->execute([':id' => $_SESSION['usuario_id']]);
    $cliente = $stmt->fetch();

    if (!$cliente) {
        throw new Exception('Cliente não encontrado.');
    }

    $dataRetirada = $_POST['data_retirada'] ?? '';
    $data = DateTimeImmutable::createFromFormat('!Y-m-d', $dataRetirada);
    $hoje = new DateTimeImmutable('today');

    if (!$data || $data->format('Y-m-d') !== $dataRetirada) {
        throw new Exception('Data de retirada inválida.');
    }

    if ($data < $hoje) {
        throw new Exception('A data de retirada não pode ser anterior a hoje.');
    }

    $diasAntecedencia = $hoje->diff($data)->days;

    $itens = $_POST['itens'] ?? [];

    if (!is_array($itens) || count($itens) === 0) {
        throw new Exception('Adicione pelo menos um produto à encomenda.');
    }

    $valorBruto = 0;
    $pesoBolos = 0;
    $qtdDoces = 0;
    $possuiBolo = false;
    $itensValidados = [];

    $stmtCategoria = $pdo->prepare("SELECT id_categoria, nome, grupo, unidade_medida,
                                           preco_unitario, quantidade_minima
                                    FROM categorias
                                    WHERE id_categoria = :id AND ativo = 1");

    foreach ($itens as $item) {
        $idCategoria = $item['categoria'] ?? '';
        $quantidade = $item['quantidade'] ?? '';

        if (!is_numeric($idCategoria) || !is_numeric($quantidade) || $quantidade <= 0) {
            throw new Exception('Produto ou quantidade inválida.');
        }

        $stmtCategoria->execute([':id' => $idCategoria]);
        $categoria = $stmtCategoria->fetch();

        if (!$categoria) {
            throw new Exception('Produto não encontrado ou indisponível.');
        }

        $quantidade = (float) $quantidade;
        $unidade = $categoria['unidade_medida'];
        $grupo = $categoria['grupo'];

        if ($quantidade < $categoria['quantidade_minima']) {
            throw new Exception(
                'A quantidade mínima para ' . $categoria['nome'] . ' é ' .
                $categoria['quantidade_minima'] . ' ' . $unidade . '.'
            );
        }

        if ($unidade !== 'kg' && floor($quantidade) != $quantidade) {
            throw new Exception('A quantidade de ' . $categoria['nome'] . ' deve ser inteira.');
        }

        $subtotal = $quantidade * $categoria['preco_unitario'];

        if ($unidade === 'cento') {
            $subtotal = $subtotal / 100;
        }

        $subtotal = round($subtotal, 2);
        $valorBruto += $subtotal;

        if ($grupo === 'bolo') {
            $possuiBolo = true;

            if ($unidade === 'kg') {
                $pesoBolos += $quantidade;
            }
        }

        if ($grupo === 'doce' && $unidade !== 'kg') {
            $qtdDoces += $quantidade;
        }

        $itensValidados[] = [
            'id_categoria'   => $categoria['id_categoria'],
            'nome_categoria' => $categoria['nome'],
            'unidade_medida' => $unidade,
            'quantidade'     => $quantidade,
            'preco_unitario' => $categoria['preco_unitario'],
            'subtotal'       => $subtotal
        ];
    }

    $percentualUrgencia = 0;
    $taxaUrgencia = 0;

    if ($possuiBolo && $diasAntecedencia < 2) {
        $percentualUrgencia = 15;
        $taxaUrgencia = round($valorBruto * 0.15, 2);
    }

    $idCupom = $_POST['id_cupom'] ?? '';
    $cupom = null;
    $desconto = 0;
    $pontosGastos = 0;

    if ($idCupom !== '') {
        if ($valorBruto < 50) {
            throw new Exception('O cupom só pode ser utilizado em encomendas a partir de R$ 50,00.');
        }

        $stmt = $pdo->prepare("SELECT id_cupom, nome, pontos_necessarios, valor_desconto
                               FROM cupons
                               WHERE id_cupom = :id AND ativo = 1");
        $stmt->execute([':id' => $idCupom]);
        $cupom = $stmt->fetch();

        if (!$cupom) {
            throw new Exception('Cupom não encontrado ou indisponível.');
        }

        $pontosGastos = (int) $cupom['pontos_necessarios'];
        $desconto = (float) $cupom['valor_desconto'];

        if ($cliente['doce_pontos'] < $pontosGastos) {
            throw new Exception('Você não possui Doce Pontos suficientes.');
        }
    }

    $valorLiquido = round($valorBruto + $taxaUrgencia - $desconto, 2);

    if ($valorLiquido < 0) {
        throw new Exception('O desconto não pode deixar o valor líquido negativo.');
    }

    $pontosBase = (int) floor($valorLiquido / 10);
    $pontosBonus = ($pesoBolos >= 2 && $qtdDoces >= 100) ? 5 : 0;
    $pontosGerados = $pontosBase + $pontosBonus;

    $stmt = $pdo->prepare("INSERT INTO encomendas
        (id_cliente, nome_cliente, telefone_contato, data_retirada, valor_bruto,
         percentual_urgencia, valor_taxa_urgencia, valor_desconto, valor_liquido,
         pontos_base, pontos_bonus, pontos_gerados, status, observacoes)
        VALUES
        (:id_cliente, :nome, :telefone, :data_retirada, :bruto,
         :percentual, :taxa, :desconto, :liquido,
         :pontos_base, :bonus, :pontos_gerados, 'aguardando', :obs)");

    $stmt->execute([
        ':id_cliente'     => $cliente['id_cliente'],
        ':nome'           => $cliente['nome'],
        ':telefone'       => $cliente['telefone'],
        ':data_retirada'  => $dataRetirada . ' 00:00:00',
        ':bruto'          => $valorBruto,
        ':percentual'     => $percentualUrgencia,
        ':taxa'           => $taxaUrgencia,
        ':desconto'       => $desconto,
        ':liquido'        => $valorLiquido,
        ':pontos_base'    => $pontosBase,
        ':bonus'          => $pontosBonus,
        ':pontos_gerados' => $pontosGerados,
        ':obs'            => trim($_POST['observacoes'] ?? '')
    ]);

    $idEncomenda = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO itens_encomenda
        (id_encomenda, id_categoria, nome_categoria, unidade_medida,
         quantidade, preco_unitario, subtotal)
        VALUES
        (:id_encomenda, :id_categoria, :nome_categoria, :unidade_medida,
         :quantidade, :preco_unitario, :subtotal)");

    foreach ($itensValidados as $item) {
        $stmt->execute([
            ':id_encomenda'   => $idEncomenda,
            ':id_categoria'   => $item['id_categoria'],
            ':nome_categoria' => $item['nome_categoria'],
            ':unidade_medida' => $item['unidade_medida'],
            ':quantidade'     => $item['quantidade'],
            ':preco_unitario' => $item['preco_unitario'],
            ':subtotal'       => $item['subtotal']
        ]);
    }

    if ($cupom) {
        $pdo->prepare("INSERT INTO historico_cupons
            (id_encomenda, id_cliente, id_cupom, nome_cupom, pontos_gastos, valor_desconto)
            VALUES (:encomenda, :cliente, :cupom, :nome, :pontos, :desconto)")
            ->execute([
                ':encomenda' => $idEncomenda,
                ':cliente'   => $cliente['id_cliente'],
                ':cupom'     => $cupom['id_cupom'],
                ':nome'      => $cupom['nome'],
                ':pontos'    => $pontosGastos,
                ':desconto'  => $desconto
            ]);

        $pdo->prepare("UPDATE clientes
                       SET doce_pontos = doce_pontos - :pontos
                       WHERE id_cliente = :id")
            ->execute([
                ':pontos' => $pontosGastos,
                ':id'     => $cliente['id_cliente']
            ]);

        $pdo->prepare("INSERT INTO historico_doce_pontos
            (id_cliente, id_encomenda, tipo, quantidade, descricao)
            VALUES (:cliente, :encomenda, 'debito', :pontos, :descricao)")
            ->execute([
                ':cliente'   => $cliente['id_cliente'],
                ':encomenda' => $idEncomenda,
                ':pontos'    => $pontosGastos,
                ':descricao' => 'Utilização do cupom ' . $cupom['nome']
            ]);
    }

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log($e->getMessage());
    http_response_code(400);
    exit('Não foi possível registrar a encomenda: ' . htmlspecialchars($e->getMessage()));
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encomenda realizada - Doce Encanto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilo-doce.css">
</head>

<body>
    <div class="page-shell">
        <div class="container">
            <div class="doce-card p-4 p-lg-5">
                <div class="text-center mb-4">
                    <div class="doce-brand">Doce Encanto</div>
                    <h1 class="title-doce mb-2">Encomenda cadastrada com sucesso!</h1>
                    <span class="badge-doce badge-doce-pink">Status: aguardando</span>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-4">
                        <p class="mb-1 text-doce-muted">Número da encomenda</p>
                        <strong><?= (int) $idEncomenda ?></strong>
                    </div>
                    <div class="col-12 col-md-4">
                        <p class="mb-1 text-doce-muted">Cliente</p>
                        <strong><?= htmlspecialchars($cliente['nome']) ?></strong>
                    </div>
                    <div class="col-12 col-md-4">
                        <p class="mb-1 text-doce-muted">Data de retirada</p>
                        <strong><?= htmlspecialchars($dataRetirada) ?></strong>
                    </div>
                </div>

                <div class="summary-box mb-4">
                    <h2 class="title-doce h4 mb-3">Resumo da encomenda</h2>
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-3">
                            <p class="mb-1 text-doce-muted">Valor bruto</p>
                            <strong>R$ <?= number_format($valorBruto, 2, ',', '.') ?></strong>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <p class="mb-1 text-doce-muted">Taxa de urgência</p>
                            <strong>R$ <?= number_format($taxaUrgencia, 2, ',', '.') ?> (<?= $percentualUrgencia ?>%)</strong>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <p class="mb-1 text-doce-muted">Desconto</p>
                            <strong>R$ <?= number_format($desconto, 2, ',', '.') ?></strong>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <p class="mb-1 text-doce-muted">Valor líquido</p>
                            <strong class="fs-5">R$ <?= number_format($valorLiquido, 2, ',', '.') ?></strong>
                        </div>
                    </div>
                </div>

                <div class="summary-box mb-4">
                    <h2 class="title-doce h4 mb-3">Doce Pontos</h2>
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <p class="mb-1 text-doce-muted">Pontos-base</p>
                            <strong><?= $pontosBase ?></strong>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="mb-1 text-doce-muted">Pontos bônus</p>
                            <strong><?= $pontosBonus ?></strong>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="mb-1 text-doce-muted">Total a receber</p>
                            <strong><?= $pontosGerados ?></strong>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="cadastrarEncomenda.php" class="btn btn-doce-secondary">Voltar ao painel de encomenda</a>
                    <a href="listarEncomendas.php" class="btn btn-doce-primary">Ver Encomendas</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>