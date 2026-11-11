
<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    die('ID inválido.');
}

// Atualizar encomenda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome_cliente']);
    $telefone = trim($_POST['telefone_contato']);
    $data = $_POST['data_retirada'];
    $observacoes = trim($_POST['observacoes']);

    $sql = "UPDATE encomendas SET
                nome_cliente = :nome,
                telefone_contato = :telefone,
                data_retirada = :data,
                observacoes = :observacoes
            WHERE id_encomenda = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':telefone' => $telefone,
        ':data' => str_replace('T', ' ', $data) . ':00',
        ':observacoes' => $observacoes,
        ':id' => $id
    ]);

    header('Location: listarEncomendas.php');
    exit;
}

// Buscar encomenda
$sql = "SELECT * FROM encomendas WHERE id_encomenda = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

$encomenda = $stmt->fetch();

if (!$encomenda) {
    die('Encomenda não encontrada.');
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar encomenda - Doce Encanto</title>
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
                        <h1 class="title-doce mb-1">Editar encomenda</h1>
                    </div>
                    <a href="listarEncomendas.php" class="btn btn-doce-secondary">Voltar</a>
                </div>

                <form method="POST" class="row g-3">
                    <input type="hidden" name="id" value="<?= $encomenda['id_encomenda'] ?>">

                    <div class="col-12 col-md-6">
                        <label class="form-label">Nome do cliente:</label>
                        <input type="text" name="nome_cliente" class="form-control"
                               value="<?= htmlspecialchars($encomenda['nome_cliente']) ?>"
                               required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Telefone:</label>
                        <input type="text" name="telefone_contato" class="form-control"
                               value="<?= htmlspecialchars($encomenda['telefone_contato']) ?>"
                               required>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">Data de retirada:</label>
                        <input type="datetime-local" name="data_retirada" class="form-control"
                               value="<?= date('Y-m-d\TH:i', strtotime($encomenda['data_retirada'])) ?>"
                               required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observações:</label>
                        <textarea name="observacoes" class="form-control" rows="4"><?= htmlspecialchars($encomenda['observacoes'] ?? '') ?></textarea>
                    </div>

                    <div class="col-12 d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-doce-primary">Salvar alterações</button>
                        <a href="listarEncomendas.php" class="btn btn-doce-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
