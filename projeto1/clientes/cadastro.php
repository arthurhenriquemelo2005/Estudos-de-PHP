<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #dbeafe 100%);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .cadastro-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
        }

        .cadastro-card {
            width: 100%;
            max-width: 900px;
            border: 0;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 24px 60px rgba(37, 99, 235, 0.12);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 22px 28px;
        }

        .card-body {
            padding: 28px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            border: 1.5px solid #dbe4f0;
            padding: 0.8rem 1rem;
            background: #f8fbff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: rgba(37, 99, 235, 0.7);
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.12);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: 0;
            border-radius: 12px;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.25);
        }
    </style>
</head>

<body>
    <div class="cadastro-wrapper">
        <div class="cadastro-card">
            <div class="card-header">
                <h1 class="h3 mb-0 fw-bold">Cadastrar Cliente</h1>
            </div>

            <div class="card-body">
                <form action="cadastrar.php" method="post">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nome</label>
                            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome Completo" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CPF/CNPJ</label>
                            <input type="text" class="form-control" name="cpf_cnpj" id="cpf_cnpj" placeholder="CPF/CNPJ" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">E-mail</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="exemplo@exemplo.com">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone</label>
                            <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Seu telefone" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Telefone Secundário</label>
                            <input type="text" class="form-control" name="telefone_sec" id="telefone_sec" placeholder="Segundo telefone">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Logradouro</label>
                            <input type="text" class="form-control" name="logradouro" id="logradouro" placeholder="Informe o logradouro" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Número</label>
                            <input type="text" class="form-control" name="numero" id="numero" placeholder="Número" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Informe seu bairro" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-semibold">Cidade</label>
                            <input type="text" class="form-control" name="cidade" id="cidade" placeholder="Sua cidade" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Estado</label>
                            <select class="form-select" name="estado" required>
                                <option value="">Selecione</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">CEP</label>
                            <input type="text" class="form-control" name="cep" id="cep" placeholder="Informe seu CEP" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>