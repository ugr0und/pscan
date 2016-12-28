<?php

namespace PScan\Scanner;

use PScan\Reporter\Reporter;

/**
 * Scanner
 *
 * Responsável por verificar em um endereço de IP
 * quais portas estão abertas.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package PScan\Scanner
 */
class Scanner
{
    /**
     * Endereço de IP a ser scanneado
     *
     * @var string
     */
    protected $ipAddr;

    /**
     * Portas a serem testadas
     *
     * @var array
     */
    protected $ports;

    /**
     * Retorna o endereço de ip sendo scanneado
     *
     * @return string
     */
    public function getIpAddr()
    {
        return $this->ipAddr;
    }

    /**
     * Define o endereço de ip a ser scanneado
     *
     * @param string $ipAddr
     */
    public function setIpAddr($ipAddr)
    {
        $this->ipAddr = $ipAddr;
    }

    /**
     * Retorna as portas a serem scanneadas
     *
     * @return array
     */
    public function getPorts()
    {
        return $this->ports;
    }

    /**
     * Define as portas a serem scanneadas
     *
     * @param array $ports
     */
    public function setPorts($ports)
    {
        $this->ports = $ports;
    }

    /**
     * Executa o scanneamento
     */
    public function execute()
    {
        $reporter = new Reporter();

        // Passa todas as portas listadas para serem scaneadas
        foreach ($this->getPorts() as $port){

            // Cria um socket
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

            // Tenta usar o socket para se conectar no ip e na porta
            $opened = @socket_connect($socket, $this->getIpAddr(), $port);

            // Exibe mensagem no console.
            echo "[+] Tentando " . $this->getIpAddr() . ":" . $port . "\n";;

            // Se não foi possível abrir o socket, passa para a próxima porta
            if(!$opened) {
                // Exibe mensagem no console.
                echo "[+] Porta $port fechada... \n\n";
                continue;
            }

            echo "[+] Porta $port aberta! \n\n";

            // Se foi possível abrir o socket, passa a info para o reporter
            $reporter->addRow($this->getIpAddr(), $port, '');
        }

        // Salva relatório
        $reporter->saveTo(__DIR__);
    }
}