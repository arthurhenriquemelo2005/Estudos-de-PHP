<?php 

require "conexao.php";

$sql = "SELECT * FROM usuarios";

$resultado = $conexao->query($sql);

echo "<h3>Lista dos Clientes</h3>";
while ($linha = $resultado->fetch_assoc()) {

    echo $linha['nome'] . "|"  ." cpf ".$linha['cpf'] ."<br>";
    
}
?>