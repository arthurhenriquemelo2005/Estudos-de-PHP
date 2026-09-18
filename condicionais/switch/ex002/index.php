    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Condicional</title>
    </head>
    <body>
        <?php 
        
        if(isset($_POST["opcao"])) {
            
        $opcao = $_POST["opcao"];

        switch ($opcao){

            case 1:
            case 2:
            case 3:
                echo "Tipo 1";
                break;
            
            case 4:
            case 5:
                echo "Tipo 2";
                break;
            
            default:
                echo "Tipo 3";
                break;

        } 
    }
        
        ?>
    </body>
    </html>