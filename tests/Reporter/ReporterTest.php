<?php

namespace Tests\Reporter;

use PScan\Reporter\Reporter;

/**
 * Testes unitários da classe reporter
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package Tests\Reporter
 */
class ReporterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Testa a classe afim de ver se ela realmente funciona.
     */
    public function testReporting()
    {
        $reporter = new Reporter();
        $reporter->addRow('127.0.0.1', 21, 'VSFTPD 2.x.x'); // Adiciona uma porta aberta fictícia
        $reporter->addRow('127.0.0.1', 80, 'Apache 2.x.x'); // Adiciona uma porta aberta fictícia
        $reporter->saveTo(__DIR__);                         // Salva do diretório do teste
    }
}