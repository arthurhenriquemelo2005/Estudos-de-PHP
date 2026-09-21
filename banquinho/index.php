<?php 

$alunos = [
    [
        'nome' => "Junin","Curso" =>"ADS", "media" => 8.5 
    ],
    [
        "nome" => "Saulo", "Curso" => "ADS", "media" => 9.6
    ],
    [
        "nome" => "Juquinha", "Curso" => "Eletrotecnica","media" => 3.5
    ],
    [
        "nome" => "Luiz", "Curso" => "Administração", "media" => 8.0
    ],
    [
        "nome" => "Julia", "Curso" => "Letras", "media" => 10.00
    ]
];

    echo "<h3>Todos os dados dos alunos</h3>";

foreach($alunos as $todosAlunos){

    if($todosAlunos['media'] >= 7 ){
        
    $status = " | Aluno Aprovado";
    
    }else{

        $status = " | Aluno Reprovado";
    }
  echo "Nome: " . $todosAlunos['nome'] . " | Curso: " . $todosAlunos['Curso'] . " | Média: " . $todosAlunos['media'] . $status."<br>";

  echo "<hr>";
}

$buscaAluno = "Julia";
$ocorrencia = false;


foreach ($alunos as $aluno){
    if ($aluno['nome'] === $buscaAluno ){
        $ocorrencia = true;
        break;
    }
}

if($ocorrencia){
    echo "<p>Aluno econtrado</p>";
}else{
    echo"<p>Aluno não encontrado</p>";
}


?>