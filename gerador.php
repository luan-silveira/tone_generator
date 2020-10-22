<?php

require_once 'cls/ToneGenerator.php';

header('Content-Type: application/json');

$intFreq  = $_POST['freq'];
$intTempo = $_POST['tempo'];
$intTaxa  = $_POST['taxa'];
$intBits  = $_POST['bits'];
$intOnda  = $_POST['onda'];

$gerador = new ToneGenerator($intTaxa, $intBits);

$intTamanhoArquivo =  $gerador->gerarTom($intFreq, $intTempo, $intOnda);

if ($intTamanhoArquivo == false) {
    die(json_encode([
        'sucesso' => false,
        'mensagem' => 'Erro ao gerar arquivo.'
    ]));
}

$strTamanho = number_format($intTamanhoArquivo / 1024, 1, ',', '.');

echo json_encode([
    'sucesso' => true,
    'mensagem' => "Arquivo gerado : 'teste.wav'. Tamanho: $strTamanho KB"
]);