
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['imagem'])) {

        $imagem = $_FILES['imagem'];

        // Verifica se ocorreu algum erro
        if ($imagem['error'] === UPLOAD_ERR_OK) {

            // Pasta onde as imagens serão armazenadas
            $pasta = 'uploads/';

            // Nome do arquivo
            $nomeImagem = basename($imagem['name']);

            // Caminho completo da pasta
            $caminho = $pasta . $nomeImagem;

            // Move o arquivo para a pasta uploads
            if (move_uploaded_file($imagem['tmp_name'], $caminho)) {

                echo "<h1>Imagem enviada com sucesso!</h1>";

                // Mostra a imagem na tela
                echo "<img src='$caminho' width='5  00'>";

            } else {

                echo "Erro ao salvar a imagem.";

            }

        } else {

            echo "Erro durante o upload.";

        }

    }

}
