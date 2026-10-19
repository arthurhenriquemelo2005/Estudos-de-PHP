    <?php


    session_start();
    require_once __DIR__ . "/../../conexao/conexao.php";


    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../../login/login.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: participantes.php");
        exit;
    }

    $id = filter_input(INPUT_POST, 'id_participante', FILTER_VALIDATE_INT);

    if (!$id || $id <= 0) {
        header("Location: participantes.php");
        exit;
    }


    //Pegando os dados do formulário de editar

    $nome  = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];


    //Validações

    if ($nome === "" || $email === "") {
        exit("Erro: nome e senha são obrigatórios");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Informe um email válido");
    }

    if ($estado !== '' && !preg_match('/^[A-Z]{2}$/', $estado)) {
        exit('Erro: informe uma UF válida com duas letras.');
    }

    try{
        //Consulta
        $sql = "
        SELECT id_usuario FROM participante
         WHERE id_participante = :id";

        $stmt = $pdo -> prepare($sql);
        $stmt ->execute(['id' => $id]);

        $participante = $stmt -> fetch(PDO::FETCH_ASSOC);

        if(!$participante){
            header("Location: participantes.php");
            exit;
        }

        $pdo ->beginTransaction();
        
        //Editando 
        $sqlUsuario = "
        UPDATE usuario SET nome = :nome, 
        email = :email 
        WHERE id_usuario = :id_usuario";

        $stmtUsuario = $pdo -> prepare($sqlUsuario);
        $stmtUsuario -> execute([
            
        ":nome" => $nome,
        ":email" => $email,
        ":id_usuario" => $participante['id_usuario'] 

        ]);

        //Editando
        $sqlParticipante = "

        UPDATE participante SET telefone = :telefone,
        endereco = :endereco,
        bairro = :bairro,
        cidade = :cidade,
        estado = :estado
        WHERE id_participante = :id

        ";

        $stmtParticipante = $pdo -> prepare($sqlParticipante);
        $stmtParticipante -> execute([

            ":telefone" => $telefone,
            ":endereco" => $endereco,
            ":bairro" => $bairro,
            ":cidade" => $cidade,
            ":estado" => $estado,
            ":id" => $id

        ]);
        
        $pdo -> commit();

        header("Location: participantes.php");
        exit;
        } catch (PDOException $e) {

            if($pdo ->inTransaction()){
                $pdo ->rollBack();
            }

            if($e -> getCode() === '23000'){
                exit("Erro: este email já está cadastrado com outro usuário");
            }

            error_log( $e ->getMessage());
            exit("Não foi possivel atualizar o participante. Verifique todos os dados e tente novamente");
        }
    ?>