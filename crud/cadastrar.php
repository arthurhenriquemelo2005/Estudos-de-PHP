<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <div class="container">
        
    <h1>Cadastrar Aluno</h1>
    
    <form action="consultar.php" method="post">

    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="name" placeholder="Informe seu Nome" required>

    <label for="nome">Email:</label>
    <input type="text" name="email" id="email" placeholder="Informe seu email" required>

    <label for="nome">Idade:</label>
    <input type="number" name="idade" id="idade" pattern="[0-9]{10,11}" required>

    <label for="nome">Curso:</label>
    <input type="text" name="curso" id="curso" placeholder="Informe seu curso" required>

    <br>
    <br>
    <input type="submit" value="Cadastrar">

   <a href="index.php">Vamo</a>
    </form>
    </div>

</body>
</html>