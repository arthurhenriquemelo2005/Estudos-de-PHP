<?php
    if (isset($_POST["tema"])) {
        
        $tema = $_POST["tema"];

        setcookie(
            "tema", $tema,
            time() + 10,
            "/"
        );

        echo "Salvamos o seu cookiezinho";
    }
?>

<form method="post">
    <h3>Escolha a cor do seu cookie</h2>

    <select name="tema">
        <option value="claro">
            Cookiezinho Branco Lindo
        </option>
        <option value="escuro">
            Cookiezinho Escuro Grande
        </option>
    </select>
    <button type="submit">
        Salvar
    </button>
</form>