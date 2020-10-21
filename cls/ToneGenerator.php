<?php

class ToneGenerator
{

    const BITS_8 = 0x8;
    const BITS_16 = 0x10;
    const BITS_24 = 0x18;

    const MONO = 1;
    const STEREO = 2;

    private $intTaxaAmostra;
    private $intBits;
    private $intQtdeCanais;

    public function __construct($intTaxaAmostra = 441000, $intBits = self::BITS_16, $intQtdeCanais = self::MONO)
    {
        $this->intTaxaAmostra = $intTaxaAmostra;
        $this->intBits = $intBits;
        $this->intQtdeCanais = $intQtdeCanais;
    }


    public function gerarTom($intFrequencia, $intSegundos)
    {
        $intTaxaBytes        = $this->intTaxaAmostra * $this->intQtdeCanais * $this->intBits / 8;
        $intAlinhamentoBloco = $this->intQtdeCanais * $this->intBits / 8;
        $intQtdeAmostras     = $this->intTaxaAmostra * $intSegundos;
        $intTamanhoDados     = $intQtdeAmostras * $this->intQtdeCanais * $this->intBits / 8;
        $intTamanhoArquivo   = 36 + $intTamanhoDados; 

        $strTamanhoCabecalho     = $this->getBytes(16, 4);                    //-- 16 bytes (PCM)
        $strTamanhoDados         = $this->getBytes($intTamanhoDados, 4);      //-- Tamanho da seção de dados do arquivo
        $strFormatoAudio         = $this->getBytes(1, 2);                     //-- 1 - PCM
        $strNumCanais            = $this->getBytes($this->intQtdeCanais, 2);  //-- Quantidade canais (Mono/Estéreo)
        $strTaxaAmostra          = $this->getBytes($this->intTaxaAmostra, 4); //-- Taxa de Amostragem
        $strTaxaBytes            = $this->getBytes($intTaxaBytes, 4);         //-- Taxa de Bytes
        $strAlinhamentoBloco     = $this->getBytes($intAlinhamentoBloco, 2);  //-- Alinhamento do bloco
        $strBits                 = $this->getBytes($this->intBits, 2);        //-- Profundidade de bits por amostra (8 bits, 16 bits, 24 bits)
        
        $strTamanhoArquivo       = $this->getBytes($intTamanhoArquivo, 4);    //-- Tamanho do arquivo, em bytes

        $strDados  = 'RIFF' . $strTamanhoArquivo . 'WAVEfmt ';
        $strDados .= $strTamanhoCabecalho . $strFormatoAudio . $strNumCanais . $strTaxaAmostra . $strTaxaBytes . $strAlinhamentoBloco . $strBits;
        $strDados .= 'data' . $strTamanhoDados . $this->gerarBytesTomSenoidal($intFrequencia, $intSegundos);

        return file_put_contents('teste.wav', utf8_decode($strDados));
    }

    /**
     * Gera os bytes da seção "data" do arquivo
     *
     * @param int $intFrequencia Frequência (Hz)
     * @param int $intSegundos   Duração (s)
     * 
     * @return void
     */
    private function gerarBytesTomSenoidal($intFrequencia, $intSegundos)
    {
        $intAmostrasPorCiclo = $this->intTaxaAmostra / $intFrequencia; //-- Quantidade de amostras por cada ciclo (amostras por Hertz)
        $intGrausPorAmostra  = 360 / $intAmostrasPorCiclo; //-- Graus (°) por amostra, para onda senoidal
        $intQtdeAmostras = $this->intTaxaAmostra * $intSegundos;

        $decGrau = 0.0;
        $strBytes = '';
        for ($i = 0; $i < $intQtdeAmostras; $i++) {
            $intBytes  = $this->intBits * sin(deg2rad($decGrau));
            $strBytesAmostra = $this->getBytes($intBytes);
            $strBytes .= $strBytesAmostra;
            if ($this->intQtdeCanais == self::STEREO) {
                $strBytes .= $strBytesAmostra;
            }
            $decGrau  += $intGrausPorAmostra;
        }

        return $strBytes;
    }


    /**
     * Retorna uma string com os bytes de um valor inteiro, no formato little-endian (ordem reversa dos bytes)
     *
     * @param int $intValor Valor inteiro, correspondente ao número de bits
     * @param int $intQtdeBytes Tamanho, em bytes. Se não informado, utiliza a profundidade de bits dividido por 8.
     * 
     * @return string
     */
    private function getBytes($intValor, $intQtdeBytes = null)
    {
        if (!$intQtdeBytes) $intQtdeBytes = $this->intBits / 8;

        $strBytes = '';
        for ($i = 0; $i < $intQtdeBytes; $i++) {
            if ($intValor > 0) {
                $intByte = $intValor % 256;
                $strBytes .= chr($intByte);
                $intValor = (int) ($intValor / 256);
            }
        }

        return $strBytes;
    }
}
