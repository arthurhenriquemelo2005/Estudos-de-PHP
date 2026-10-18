
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Participante | EcoPoint</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <header class="topbar">
        <a href="../../painel/painel.php" class="brand">
            <span class="brand-mark">E</span>
            <span>EcoPoint</span>
        </a>

        <div class="user-area">
            <span>Novo participante</span>
            <a href="../../painel/logout.php" class="btn-sair">Sair</a>
        </div>
    </header>

    <main class="container page-content">

        <div class="page-heading">
            <div>
                <span class="eyebrow">GESTÃO DO SISTEMA</span>
                <h1>Cadastrar participante</h1>
                <p>Preencha os dados para cadastrar um novo participante.</p>
            </div>
        </div>

        <section class="content-card form-card">

            <div class="card-heading">
                <h2>Dados do participante</h2>
                <p>Preencha todos os campos obrigatórios.</p>
            </div>

            <form action="cadastro.php" method="POST" class="participant-form">

                <h3 class="section-title">Dados de acesso</h3>

                <div class="row g-3">

                    <div class="col-12">
                        <label for="nome" class="form-label">
                            Nome completo
                        </label>

                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            class="form-control"
                            maxlength="150"
                            required>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">
                            E-mail
                        </label>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            maxlength="150"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="senha" class="form-label">
                            Senha
                        </label>

                        <input
                            type="password"
                            name="senha"
                            id="senha"
                            class="form-control"
                            required>
                    </div>

                </div>

                <h3 class="section-title mt-4">Dados de contato</h3>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="telefone" class="form-label">
                            Telefone
                        </label>

                        <input
                            type="tel"
                            name="telefone"
                            id="telefone"
                            class="form-control"
                            maxlength="20"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="endereco" class="form-label">
                            Endereço
                        </label>

                        <input
                            type="text"
                            name="endereco"
                            id="endereco"
                            class="form-control"
                            maxlength="200"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="bairro" class="form-label">
                            Bairro
                        </label>

                        <input
                            type="text"
                            name="bairro"
                            id="bairro"
                            class="form-control"
                            maxlength="100"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label for="cidade" class="form-label">
                            Cidade
                        </label>

                        <input
                            type="text"
                            name="cidade"
                            id="cidade"
                            class="form-control"
                            maxlength="100"
                            required>
                    </div>

                    <div class="col-md-4">
                        <label for="estado" class="form-label">
                            Estado (UF)
                        </label>

                        <select
                            name="estado"
                            id="estado"
                            class="form-select"
                            required>

                            <option value="">Selecione</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AP">AP</option>
                            <option value="AM">AM</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MT">MT</option>
                            <option value="MS">MS</option>
                            <option value="MG">MG</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PR">PR</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RS">RS</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="SC">SC</option>
                            <option value="SP">SP</option>
                            <option value="SE">SE</option>
                            <option value="TO">TO</option>

                        </select>
                    </div>

                </div>

                <div class="form-actions">

                    <a href="participantes.php" class="btn-cancel">
                        Cancelar
                    </a>

                    <button type="submit" class="btn-eco">
                        Cadastrar participante
                    </button>

                </div>

            </form>

        </section>

    </main>

    <footer>
        <p>
            &copy; 2026 EcoPoint — Sistema de gestão de coleta sustentável.
        </p>
    </footer>

</body>

</html>
