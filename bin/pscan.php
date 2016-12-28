<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * Função para ler o que o usuário digitou.
 *
 * @return string
 */
function readInput()
{
    $fp = fopen("php://stdin","r");
    $line = rtrim(fgets($fp, 1024));
    return $line;
}

// Solicita o IP ao usuário
echo "[+] IP...............: ";
$ipAddr = readInput();

// Pergunta se usará o arquivo Ports.txt
echo "[+] ports.txt [Y/n]..:";
$portsTxt = (readInput() == "Y");

if(!$portsTxt){
    echo "[+] Porta inicial....:";
    $pInicial = (int) readInput();

    echo "[+} Porta final......:";
    $pFinal = (int) readInput();

    // Cria uma array com o range de portas
    $ports = range($pInicial, $pFinal);
}
else
{
    // Cria uma array com as portas em ports.txt
    $ports = file(__DIR__ . '/ports.txt');
}

echo "\n\n INICIANDO... \n\n";

$scanner = new \PScan\Scanner\Scanner();
$scanner->setIpAddr($ipAddr);
$scanner->setPorts($ports);
$scanner->execute();