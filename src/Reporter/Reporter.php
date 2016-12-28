<?php

namespace PScan\Reporter;

use Minerva\Collections\Collection;

/**
 * Reporter
 *
 * Classe responsável por criar relatórios sobre o processo
 * de escaneamento executado pelo scanner.
 *
 * @author  Lucas A. de Araújo <lucas@minervasistemas.com.br>
 * @package PScan\Reporter
 */
class Reporter
{
    /**
     * Coleção de linhas a serem reportadas
     *
     * @var Collection
     */
    protected $rows;

    /**
     * Construtor
     *
     * O construtor irá executar uma série de comandos
     * afim de preparar a classe quando ela for instanciada.
     */
    public function __construct()
    {
        $this->rows = new Collection();
    }

    /**
     * Adiciona uma linha para ser escrita
     *
     * @param string $ipAddr Endereço de IP
     * @param int $port Número da porta
     * @param string $banner Banner recebido pelo socket
     */
    public function addRow($ipAddr, $port, $banner)
    {
        // Adiciona na coleção de linhas uma array
        // contendo as informações da nova linha.
        $this->rows->add([
            $ipAddr,
            $port,
            $banner
        ]);
    }

    /**
     * Informa uma pasta para salvar o relatório
     *
     * @param string $folder
     */
    public function saveTo($folder)
    {
        // Verifica se a pasta informada onde o report deverá ser
        // salvo existe. Se não existir, a execução será interrompida.
        if(!is_dir($folder))
            throw new \RuntimeException("Diretório $folder não encontrado.");

        // O nome do report será gerado de acordo com o datetime da execução
        // então pegarei a data atual para gerar o nome do arquivo.
        // ficará algo como 20161228102035.csv, em função de 2016/12/28 10:21:35.
        $dataAtual = new \DateTime('now');
        $fileName = $dataAtual->format('Ymdhis') . '.csv';

        // Cria o arquivo e o prepara para escrita
        $stream = fopen($fileName, "a+");

        // Caso tenha ocorrido algum erro durante a abertura do arquivo
        // a execução do programa será interrompida.
        if(!$stream)
            throw new \RuntimeException("Não foi possível gerar o relatório na pasta $folder.");

        // Irá realizar um foreach para escrever cada elemento
        // contido na coleção de linhas no stream.
        $this->rows->each(function(array $row) use($stream){
            fwrite($stream, "{$row[0]}|{$row[1]}|{$row[2]}\n");
        });

        // Fecha o arquivo
        fclose($stream);
    }
}