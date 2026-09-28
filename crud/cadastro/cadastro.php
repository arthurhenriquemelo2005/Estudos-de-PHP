<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastro de Clientes</h1>
    
        <form action="cadastrar.php" method="post">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"  placeholder="Informe seu nome" required >
        
        <br><br>

        <label for="cpf">Cpf:</label>
        <input type="text" id="cpf" name="cpf" placeholder="Informe seu CPF" pattern="[0-9]{11}" required>
        
        <br><br>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Informe o seu email" required>

        <br><br>

        <label for="telefone">Telefone:</label>
        <input type="tel" id="telefone" name="telefone" placeholder="Informe seu telefone" 
        pattern="[0-9]{10,11}" required>

        <br><br>

        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" placeholder="Informe sua cidade" required>

        <br><br>

        <input type="submit" value="Cadastrar">
                
        </form>
</body>
</html>