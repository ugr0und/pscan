<?php

namespace Tests\Scanner;

use PScan\Scanner\Scanner;

/**
 * ScannerTest
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Tests\Scanner
 */
class ScannerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa um scaneamento de portas simples
     */
    public function testScanning()
    {
        $ipAddr = '127.0.0.1'; // IP a ser testado
        $ports  = [21, 80, 3790, 3000]; // Portas a serem testadas

        $scanner = new Scanner();
        $scanner->setIpAddr($ipAddr); // Define o ip a ser escaneado
        $scanner->setPorts($ports);   // Define as portas a serem escaneadas
        $scanner->execute();          // Execute o scanner
    }
}