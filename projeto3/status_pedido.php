<?php
/**
 * Obtém os status permitidos pela coluna status da tabela pedidos.
 * Isso mantém os formulários alinhados ao ENUM definido no MySQL.
 */
function obterStatusPermitidos(PDO $pdo): array
{
    $coluna = $pdo->query("SHOW COLUMNS FROM pedidos LIKE 'status'")->fetch();
    $status = [];

    if ($coluna && preg_match('/^enum\((.*)\)$/i', $coluna['Type'], $partes)) {
        preg_match_all("/'((?:[^'\\\\]|\\\\.)*)'/", $partes[1], $valores);
        foreach ($valores[1] as $valor) {
            $status[] = stripcslashes($valor);
        }
    }

    // Fallback para colunas VARCHAR ou schemas sem ENUM.
    if (!$status) {
        $status = ['PENDENTE', 'CONFIRMADO', 'EM_PREPARO', 'ENTREGUE', 'CANCELADO'];
    }

    return $status;
}

function rotuloStatusPedido(string $status): string
{
    $rotulos = [
        'PENDENTE' => 'Pendente',
        'CONFIRMADO' => 'Confirmado',
        'EM_PREPARO' => 'Em preparo',
        'EM ANDAMENTO' => 'Em andamento',
        'EM_ANDAMENTO' => 'Em andamento',
        'ENTREGUE' => 'Entregue',
        'CONCLUIDO' => 'Concluído',
        'CONCLUÍDO' => 'Concluído',
        'CANCELADO' => 'Cancelado',
        'AGUARDANDO' => 'Aguardando',
        'AGUARDANDO_APROVACAO' => 'Aguardando aprovação',
        'AGUARDANDO_APROVAÇÃO' => 'Aguardando aprovação'
    ];

    return $rotulos[$status] ?? ucfirst(strtolower(str_replace('_', ' ', $status)));
}
