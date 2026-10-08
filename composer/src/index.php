<?php

    require __DIR__.'/../vendor/autoload.php';

    use GuzzleHttp\Client;

    $client = new Client();

    $response = $client->request('GET', 'https://economia.awesomeapi.com.br/last/USD-BRL,EUR-BRL,BRL-ARS,GBP-BRL');

    $dados = json_decode($response->getBody(), true);

    $dolar = $dados['USDBRL'];
    $euro = $dados['EURBRL'];
    $peso = $dados['BRLARS'];
    $libra = $dados['GBPBRL'];

    echo "Dolar R$: ".($dolar['bid'])."<br>";
    echo "Euro R$: ".($euro['bid'])."<br>";
    echo "Valor do Real na Argentina $: ".($peso['bid'])."<br>";
    echo "Libra R$: ".($libra['bid'])."<br>";


?>
