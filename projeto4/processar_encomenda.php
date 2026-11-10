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
</head>

<body>

    <h1>Encomenda cadastrada com sucesso!</h1>

    <p>Número da encomenda: <strong><?= (int) $idEncomenda ?></strong></p>
    <p>Cliente: <?= htmlspecialchars($cliente['nome']) ?></p>
    <p>Data de retirada: <?= htmlspecialchars($dataRetirada) ?></p>

    <hr>

    <h2>Resumo da encomenda</h2>
    <p>Valor bruto: R$ <?= number_format($valorBruto, 2, ',', '.') ?></p>
    <p>Taxa de urgência (<?= $percentualUrgencia ?>%): R$ <?= number_format($taxaUrgencia, 2, ',', '.') ?></p>
    <p>Desconto: R$ <?= number_format($desconto, 2, ',', '.') ?></p>
    <h3>Valor líquido: R$ <?= number_format($valorLiquido, 2, ',', '.') ?></h3>

    <hr>

    <h2>Doce Pontos</h2>
    <p>Pontos-base: <?= $pontosBase ?></p>
    <p>Pontos bônus: <?= $pontosBonus ?></p>
    <p>Total a receber após confirmação do pagamento: <strong><?= $pontosGerados ?></strong></p>
    <p>Status: aguardando</p>

    <a href="painel.php">Voltar ao painel</a>

</body>

</html>