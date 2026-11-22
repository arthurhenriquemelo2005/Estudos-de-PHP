<?php 

    require_once (__DIR__.'/../conexao.php');

   $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

   $sql = "DELETE FROM categorias WHERE id = :id";

   $stmt = $pdo ->prepare($sql);

   $stmt -> execute([

        ":id" => $id

   ]);

   header("Location: verCategorias.php");
   exit;




?>