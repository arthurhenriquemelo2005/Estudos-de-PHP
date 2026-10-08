<?php

require __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

$response = $client->request('GET', 'https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BRL-ARS,GBP-BRL');

$dados = json_decode($response->getBody(), true);

$dolar = $dados['USDBRL'];
$euro = $dados['EURBRL'];
$peso = $dados['BRLARS'];
$libra = $dados['GBPBRL'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotação de Moedas</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="container">
        <section class="card">
            <h1>Cotação das moedas</h1>

            <div class="moeda">
                <span class="label">Dólar</span>
                <span class="valor">R$ <?= number_format((float) $dolar['bid'], 2, ',', '.') ?></span>
            </div>

            <div class="moeda">
                <span class="label">Euro</span>
                <span class="valor">R$ <?= number_format((float) $euro['bid'], 2, ',', '.') ?></span>
            </div>

            <div class="moeda">
                <span class="label">Real para Argentina</span>
                <span class="valor">$ <?= number_format((float) $peso['bid'], 2, ',', '.') ?></span>
            </div>

            <div class="moeda">
                <span class="label">Libra</span>
                <span class="valor">R$ <?= number_format((float) $libra['bid'], 2, ',', '.') ?></span>
            </div>
        </section>
    </main>
</body>
</html>
