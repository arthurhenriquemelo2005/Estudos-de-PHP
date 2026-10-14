<?php

const API_URL = 'https://pokeapi.co/api/v2';

function api_get(string $endpoint): ?array
{
    $dir = __DIR__ . '/cache';

    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    $endpoint = ltrim($endpoint, '/');

    $url = API_URL . '/' . $endpoint;
    $file = $dir . '/' . md5($url) . '.json';

    // Verifica se existe cache válido por até uma hora
    if (is_file($file) && time() - filemtime($file) < 3600) {
        $dados = json_decode(file_get_contents($file), true);

        if (is_array($dados)) {
            return $dados;
        }
    }

    // Inicializa a requisição HTTP
    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json'
        ],
    ]);

    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Verifica se a API respondeu com sucesso
    if ($body === false || $status !== 200) {
        return null;
    }

    $dados = json_decode($body, true);

    if (!is_array($dados)) {
        return null;
    }

    // Guarda a resposta para reutilizá-la
    file_put_contents($file, $body, LOCK_EX);

    return $dados;
}

function h($texto): string
{
    return htmlspecialchars(
        (string) $texto,
        ENT_QUOTES,
        'UTF-8'
    );
}

function sprite(int $id): string
{
    return 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/' . $id . '.png';
}

function sprite_shiny(int $id): string
{
    return 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/shiny/' . $id . '.png';
}

function imagem(int $id): string
{
    return sprite($id);
}
