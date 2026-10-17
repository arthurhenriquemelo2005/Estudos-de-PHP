<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro | EcoPoint</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        :root {
            --eco-green: #15803d;
            --eco-green-dark: #14532d;
            --eco-text: #172b22;
            --eco-muted: #64756b;
        }

        body {
            min-height: 100vh;
            color: var(--eco-text);
            background:
                radial-gradient(circle at 8% 10%, rgba(187, 247, 208, .55), transparent 30%),
                linear-gradient(135deg, #f4fbf5 0%, #f8fafc 55%, #ecfdf5 100%);
            font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        .page-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
        }

        .signup-card {
            overflow: hidden;
            border: 1px solid rgba(21, 128, 61, .12);
            border-radius: 1.5rem;
            background: #fff;
            box-shadow: 0 24px 70px rgba(20, 83, 45, .12);
        }

        .brand-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100%;
            padding: clamp(2rem, 4vw, 3.5rem);
            color: #fff;
            background: linear-gradient(145deg, #166534 0%, #15803d 53%, #0f766e 100%);
        }

        .brand-logo {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -.04em;
        }

        .brand-mark {
            display: inline-grid;
            width: 2.7rem;
            height: 2.7rem;
            place-items: center;
            border-radius: .9rem;
            color: var(--eco-green-dark);
            background: #fff;
            font-size: 1.45rem;
        }

        .brand-panel h1 {
            max-width: 25rem;
            margin-top: 4rem;
            font-size: clamp(2.2rem, 4vw, 3.35rem);
            font-weight: 800;
            letter-spacing: -.045em;
            line-height: 1.07;
        }

        .brand-panel .lead {
            max-width: 24rem;
            color: rgba(255, 255, 255, .85);
            line-height: 1.7;
        }

        .benefit {
            display: flex;
            align-items: center;
            gap: .85rem;
            margin-top: 1.15rem;
            color: rgba(255, 255, 255, .94);
        }

        .benefit-icon {
            display: grid;
            width: 2.5rem;
            height: 2.5rem;
            flex-shrink: 0;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: .8rem;
            background: rgba(255, 255, 255, .1);
        }

        .form-panel {
            padding: clamp(1.5rem, 3.5vw, 3.25rem);
        }

        .eyebrow {
            color: var(--eco-green);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .form-title {
            margin: .45rem 0 .5rem;
            font-size: clamp(1.8rem, 3vw, 2.35rem);
            font-weight: 800;
            letter-spacing: -.04em;
        }

        .form-subtitle {
            color: var(--eco-muted);
        }

        .form-label {
            margin-bottom: .4rem;
            color: #35483c;
            font-size: .88rem;
            font-weight: 650;
        }

        .form-control {
            min-height: 3rem;
            border-color: #dce7de;
            border-radius: .75rem;
            background-color: #fcfefc;
        }

        .form-control:focus {
            border-color: #4ade80;
            box-shadow: 0 0 0 .22rem rgba(34, 197, 94, .13);
        }

        .form-text {
            color: var(--eco-muted);
            font-size: .78rem;
        }

        .btn-eco {
            min-height: 3.15rem;
            border: 0;
            border-radius: .8rem;
            color: #fff;
            background: linear-gradient(100deg, #15803d, #0f766e);
            font-weight: 750;
            box-shadow: 0 10px 22px rgba(21, 128, 61, .18);
            transition: transform .15s ease, box-shadow .15s ease;
        }

        .btn-eco:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 13px 26px rgba(21, 128, 61, .24);
        }

        .login-note {
            color: var(--eco-muted);
            font-size: .9rem;
        }

        .login-note a {
            color: var(--eco-green);
            font-weight: 750;
            text-decoration: none;
        }

        .login-note a:hover {
            text-decoration: underline;
        }

        .privacy-note {
            color: #718076;
            font-size: .76rem;
            line-height: 1.55;
        }

        @media (max-width: 767.98px) {
            .page-wrap {
                padding: 1rem 0;
            }

            .signup-card {
                border-radius: 1rem;
            }

            .brand-panel {
                min-height: auto;
                padding: 1.6rem;
            }

            .brand-panel h1 {
                margin-top: 2rem;
                font-size: 2.1rem;
            }

            .form-panel {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>

<main class="page-wrap">
    <div class="container">

        <div class="signup-card row g-0">

            <aside class="col-lg-5">
                <div class="brand-panel h-100">

                    <div>
                        <div class="brand-logo">
                            <span class="brand-mark" aria-hidden="true">🍃</span>
                            <span>EcoPoint</span>
                        </div>

                        <h1>
                            Pequenas atitudes.
                            <span class="text-warning">Grandes mudanças.</span>
                        </h1>

                        <p class="lead mt-4">
                            Faça parte de uma comunidade que transforma o cuidado
                            com o meio ambiente em benefícios.
                        </p>

                        <div class="benefits mt-4">

                            <div class="benefit">
                                <span class="benefit-icon" aria-hidden="true">♻</span>
                                <span>
                                    <strong>Recicle</strong><br>
                                    <small>Ajude a dar um destino correto aos resíduos.</small>
                                </span>
                            </div>

                            <div class="benefit">
                                <span class="benefit-icon" aria-hidden="true">✦</span>
                                <span>
                                    <strong>Acumule EcoPoints</strong><br>
                                    <small>Acompanhe seus pontos a cada coleta.</small>
                                </span>
                            </div>

                            <div class="benefit">
                                <span class="benefit-icon" aria-hidden="true">♧</span>
                                <span>
                                    <strong>Troque por recompensas</strong><br>
                                    <small>Use seus pontos para resgatar cupons.</small>
                                </span>
                            </div>

                        </div>
                    </div>

                    <p class="small mb-0 mt-5 text-white-50">
                        Transformando resíduos em benefícios.
                    </p>

                </div>
            </aside>

            <section class="col-lg-7">
                <div class="form-panel">

                    <div class="eyebrow">Crie sua conta</div>

                    <h2 class="form-title">Vamos começar?</h2>

                    <p class="form-subtitle mb-4">
                        Preencha seus dados para participar do EcoPoint.
                    </p>

                    <form
                        id="formCadastro"
                        action="cadastrar.php"
                        method="post"
                        class="needs-validation"
                        novalidate
                    >

                        <div class="mb-4">
                            <label for="nome" class="form-label">
                                Nome completo
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="nome"
                                name="nome"
                                autocomplete="name"
                                minlength="3"
                                maxlength="120"
                                placeholder="Digite seu nome completo"
                                required
                            >

                            <div class="invalid-feedback">
                                Informe seu nome completo.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label">
                                E-mail
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                autocomplete="email"
                                maxlength="150"
                                placeholder="voce@exemplo.com"
                                required
                            >

                            <div class="invalid-feedback">
                                Informe um e-mail válido.
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="senha" class="form-label">
                                Senha
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="senha"
                                name="senha"
                                autocomplete="new-password"
                                minlength="8"
                                placeholder="Crie uma senha"
                                required
                            >

                            

                            
                        </div>

                        <div class="mb-4">
                            <label for="confirmar_senha" class="form-label">
                                Confirmar senha
                            </label>

                            <input
                                type="password"
                                class="form-control"
                                id="confirmar_senha"
                                name="confirmar_senha"
                                autocomplete="new-password"
                                minlength="8"
                                placeholder="Digite a senha novamente"
                                required
                            >

                            <div class="invalid-feedback" id="erroConfirmacao">
                                As senhas não coincidem.
                            </div>
                        </div>

                        <button type="submit" class="btn btn-eco w-100 mt-2">
                            Criar minha conta →
                        </button>

                        <p class="login-note text-center mt-4 mb-2">
                            Já tem uma conta?
                            <a href="login.php">Entrar</a>
                        </p>

                        <p class="privacy-note text-center mb-0">
                            Seus dados devem ser tratados com segurança.
                        </p>

                    </form>
                </div>
            </section>

        </div>

        <p class="text-center text-secondary small mt-3 mb-0">
            © <span id="ano"></span> EcoPoint · Recicle, acumule pontos e faça a diferença.
        </p>

    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
    (() => {
        'use strict';

       

        function validarSenhas() {
            if (confirmarSenha.value === '') {
                confirmarSenha.setCustomValidity('');
                return;
            }

            if (senha.value !== confirmarSenha.value) {
                confirmarSenha.setCustomValidity('As senhas não coincidem.');
            } else {
                confirmarSenha.setCustomValidity('');
            }
        }

        senha.addEventListener('input', validarSenhas);
        confirmarSenha.addEventListener('input', validarSenhas);

        form.addEventListener('submit', (event) => {
            validarSenhas();

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        });

        document.getElementById('ano').textContent = new Date().getFullYear();
    })();
</script>

</body>
</html>