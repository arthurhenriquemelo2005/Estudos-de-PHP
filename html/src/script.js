const form = document.getElementById("formCadastro");
const mensagemErro = document.getElementById("mensagemErro");

form.addEventListener("submit", function(event) {
    const nome = document.getElementById("nome").value;
    const email = document.getElementById("email").value;

    if (nome == "") {
        event.preventDefault();
        mensagemErro.innerHTML = "Digite seu nome.";
        return;
    }

    if (email == "") {
        event.preventDefault();
        mensagemErro.innerHTML = "Digite seu e-mail.";
        return;
    }

    if (!email.includes("@")) {
        event.preventDefault();
        mensagemErro.innerHTML = "Digite um e-mail válido.";
        return;
    }

    mensagemErro.innerHTML = "";
});