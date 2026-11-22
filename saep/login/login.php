<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <form action="autenticar.php" method="post">

        <h1>Login</h1>

        <label for="email">E-mail</label>
        <input type="email" name="email" id= "email" placeholder="E-mail"required>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" placeholder="Digite sua senha"required> 

        <input type="submit" value="Entrar">

    </form>
    
</body>
</html>