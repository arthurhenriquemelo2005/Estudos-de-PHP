<?php 

    session_start();
    require_once "conexao.php";

    if(!isset($_SESSION['id_usuario'])){
        header("Location: login.php");
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: filme.php");
        exit;
    }

    $titulo = trim($_POST['titulo'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $genero = trim($_POST['genero']);
    $anoLancamento =  filter_input(
    INPUT_POST,
    'ano_lancamento',
    FILTER_VALIDATE_INT
);

    $diretor = trim($_POST['diretor']);
    $quantidadeTotal = trim($_POST['quantidade_total']);


    if (
    $titulo === '' ||
    $categoria === '' ||
    $genero === '' ||
    !$anoLancamento ||
    $anoLancamento < 1888 ||
    $anoLancamento > (int) date('Y') ||
    !$quantidadeTotal ||
    $quantidadeTotal < 1
) {
    $_SESSION['mensagem'] = 'Verifique os dados informados.';
    header("Location: filme.php");
    exit;
}


    try{
        
        $sql = "INSERT INTO filmes
            (
                titulo,
                categoria,
                genero,
                ano_lancamento,
                diretor,
                quantidade_total,
                quantidade_disponivel,
                status
            )
            VALUES
            (
                :titulo,
                :categoria,
                :genero,
                :ano_lancamento,
                :diretor,
                :quantidade_total,
                :quantidade_disponivel,
                'ATIVO'
            )";

        $stmt = $pdo ->prepare($sql);

        $stmt ->execute([

            ":titulo" => $titulo,
             ':categoria' => $categoria,
            ':genero' => $genero,
            ':ano_lancamento' => $anoLancamento,
            ':diretor' => $diretor !== '' ? $diretor : null,
            ':quantidade_total' => $quantidadeTotal,
            ':quantidade_disponivel' => $quantidadeTotal
        ]);

        $_SESSION['mensagem'] = 'Filme cadastrado com sucesso';
    } catch(PDOException $e){
        
        $_SESSION['mensagem'] = 'Erro ao cadastrar o filme'; 
    }

    header("Location: filme.php");
    exit;
?>