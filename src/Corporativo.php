<?php

namespace FruiVita\Corporativo;

use FruiVita\Corporativo\Contracts\IImportavel;
use FruiVita\Corporativo\Events\ImportacaoConcluida;
use FruiVita\Corporativo\Events\ImportacaoIniciada;
use FruiVita\Corporativo\Exceptions\FileNotReadableException;
use FruiVita\Corporativo\Exceptions\UnsupportedFileTypeException;
use FruiVita\Corporativo\Importadores\ImportadorCargo;
use FruiVita\Corporativo\Importadores\ImportadorFuncaoConfianca;
use FruiVita\Corporativo\Importadores\ImportadorLotacao;
use FruiVita\Corporativo\Importadores\ImportadorUsuario;
use FruiVita\Corporativo\Trait\Eventos;

class Corporativo implements IImportavel
{
    use Eventos;

    /**
     * Caminho completo para o arquivo XML com a estrutura coporativa que será
     * importado.
     *
     * @var string
     */
    protected $arquivo;

    /**
     * Mime types suportados.
     *
     * @var string[]
     */
    protected $mime_types = ['application/xml', 'text/xml'];

    /**
     * {@inheritdoc}
     */
    public function importar(string $arquivo)
    {
        throw_if(!$this->podeSerLido($arquivo), FileNotReadableException::class);
        throw_if(!$this->mimeTypePermitido($arquivo), UnsupportedFileTypeException::class);

        $this
            ->setPathArquivo($arquivo)
            ->tratativasIniciais()
            ->executar()
            ->tratativasFinais();
    }

    /**
     * Verifica se o arquivo informado existe e pode ser lido.
     *
     * @param  string  $arquivo caminho completo para o arquivo
     * @return bool
     */
    private function podeSerLido(string $arquivo)
    {
        $pode_ser_lido = is_readable($arquivo);

        clearstatcache();

        return $pode_ser_lido;
    }

    /**
     * Verifica se o mime type do arquivo é permitido.
     *
     * @param  string  $arquivo caminho completo
     * @return bool
     */
    private function mimeTypePermitido(string $arquivo)
    {
        return in_array(
            needle: mime_content_type($arquivo),
            haystack: $this->mime_types
        );
    }

    /**
     * Define o caminho completo do arquivo que será importado.
     *
     * @param  string  $arquivo caminho completo
     * @return static
     */
    private function setPathArquivo(string $arquivo)
    {
        $this->arquivo = $arquivo;

        return $this;
    }

    /**
     * Tratativas iniciais para a importação.
     *
     * @return static
     */
    private function tratativasIniciais()
    {
        ImportacaoIniciada::dispatchIf($this->emitirEventos(), $this->arquivo, now());

        return $this;
    }

    /**
     * Executa a importação.
     *
     * @return static
     */
    private function executar()
    {
        ImportadorCargo::make()->importar($this->arquivo);
        ImportadorFuncaoConfianca::make()->importar($this->arquivo);
        ImportadorLotacao::make()->importar($this->arquivo);
        ImportadorUsuario::make()->importar($this->arquivo);

        return $this;
    }

    /**
     * Tratativas finais da importação.
     *
     * @return static
     */
    private function tratativasFinais()
    {
        ImportacaoConcluida::dispatchIf($this->emitirEventos(), $this->arquivo, now());

        return $this;
    }
}
