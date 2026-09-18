<?php 

    $numero1 = $_POST['numero1'];
    $numero2 = $_POST['numero2'];

    $operacao = $_POST['operacao'];

    switch ($operacao) {

        case 1:
            $operacao = $numero1 + $numero2;
            echo "O resultado da soma é $operacao";
            break;
        
        case 2:
            $operacao = $numero1 - $numero2;
            echo "O resultado da subtração é $operacao";
            break;  

        case 3:
            $operacao = $numero1 * $numero2;   
            echo "O resultado da multiplicação é $operacao";
            break;
        
        case 4:
            
            if ($numero2 == 0) {
                echo "Não é possível dividir por zero.";
                break;
            }
            $operacao = $numero1 / $numero2;

            echo "O resultado da divisão é $operacao";
            break;
    }   

?>