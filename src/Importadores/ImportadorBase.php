<?php

namespace FruiVita\Corporativo\Importadores;

use FruiVita\Corporativo\Importadores\Contracts\IImportavel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

abstract class ImportadorBase implements IImportavel
{
    /**
     * Regras que serão aplicadas para cada campo do nó XML que será importado.
     *
     * @var array<string, mixed[]> assoc array
     */
    protected $rules;

    /**
     * Nome do nó XML que será importado.
     *
     * @var string
     */
    protected $nome_no;

    /**
     * Atributos (campos) para se considerar único o objeto no banco de dados.
     *
     * @var string[]
     */
    protected $unique;

    /**
     * Atributos (campos) que devem ser atualizados no banco de dados se o
     * objeto já estiver cadastrado.
     *
     * @var string[]
     */
    protected $atualizar_campos;

    /**
     * Caminho completo para o arquivo XML que será importado.
     *
     * @var string
     */
    protected $arquivo;

    /**
     * Número de registros que serão inseridos/atualizados em uma única query.
     *
     * @var int
     */
    protected $max_upsert;

    /**
     * {@inheritdoc}
     */
    public function importar(string $arquivo)
    {
        $this
            ->setPathArquivo($arquivo)
            ->setMaxUpsert()
            ->executar();
    }

    /**
     * Define o caminho do arquivo que será importado.
     *
     * @param string $arquivo caminho completo do arquivo
     *
     * @return static
     */
    private function setPathArquivo(string $arquivo)
    {
        $this->arquivo = $arquivo;

        return $this;
    }

    /**
     * Define o número de registros que serão cadastrados/atualizados em uma
     * única query.
     *
     * @return static
     */
    private function setMaxUpsert()
    {
        $maximo = config('corporativo.max_upsert');

        $this->max_upsert = (is_int($maximo) && $maximo >= 1)
                                ? $maximo
                                : 500;

        return $this;
    }

    /**
     * Extrai os dados/campos de interesse para o objeto do nó XML.
     *
     * O array conterá os dados/campos de interesse (chave) e seus respectivos
     * valores extraídos do nó XML infromado.
     *
     * Ex.: [
     *     'id' => '10',
     *     'nome' => 'foo',
     * ]
     *
     * @param \XMLReader $no nó de onde serão extraído os valores
     *
     * @return array<string, string> array associativo
     */
    abstract protected function extrairDadosDoNo(\XMLReader $no);

    /**
     * Salva os itens validados.
     *
     * @param \Illuminate\Support\Collection $validados
     *
     * @return void
     */
    abstract protected function salvar(Collection $validados);

    /**
     * Posiciona o XMLReader no primeiro nó de interesse.
     *
     * Ex: se o nó de interesse for **cargo**, o arquivo XML será lido pelo
     * **XMLReader** até encontrá-lo e retorná-lo com o ponteiro apontando para
     * o primeiro nó de nome **cargo**.
     *
     * @return \XMLReader
     *
     * @see https://drib.tech/programming/parse-large-xml-files-php
     */
    protected function lerAPartirDe()
    {
        $xml = new \XMLReader();
        $xml->open($this->arquivo);

        // em busca do primeiro elemento
        while ($xml->read() && $xml->name != $this->nome_no) {
        }

        return $xml;
    }

    /**
     * Executa a importação.
     *
     * A execução é feita por meio dos seguintes passos.
     * - Ler o arquivo;
     * - Extrai os dados do nó XML de interesse;
     * - Validar os dados extraídos e, se necessário, registrar em log as
     * inconsistencias;
     * - Acionar o método responsável por efetivar a persistência.
     *
     * @return static
     *
     * @see https://drib.tech/programming/parse-large-xml-files-php
     */
    protected function executar()
    {
        $validados = collect();

        $xml = $this->lerAPartirDe();

        // percorre os elementos
        while ($xml->name == $this->nome_no) {
            $dados = $this->extrairDadosDoNo($xml);

            $valido = $this->validaELogaErro($dados);

            if ($valido) {
                $validados->push($valido);
            }

            // salva a quantidade de registros definida por vez
            if ($validados->count() >= $this->max_upsert) {
                $this->salvar($validados);
                $validados = collect();
            }

            // move o ponteiro para o próximo registro
            $xml->next($this->nome_no);
        }

        $xml->close();

        // salvar o restante dos registros
        $validados->whenNotEmpty(function ($validados) {
            $this->salvar($validados);
        });

        return $this;
    }

    /**
     * Retorna dados válidos de acordo com as regras de importação.
     *
     * Caso a validação falhe, retorna null e registra em log as falhas.
     *
     * @param array<string, string> $dados assoc array
     *
     * @return array<string, string>|null assoc array
     */
    private function validaELogaErro(array $dados)
    {
        $validador = Validator::make($dados, $this->rules);

        if ($validador->fails()) {
            $this->log(
                'warning',
                __('Validação falhou'),
                [
                    'dados' => $dados,
                    'erros' => $validador->getMessageBag()->toArray(),
                ]
            );

            return null;
        }

        return $validador->validated();
    }

    /**
     * Loga com um nível arbitrário.
     *
     * A mensagem PRECISA ser uma string ou um objeto que implemente
     * __toString().
     *
     * A mensagem PODE conter placeholders no formato: {foo} em que 'foo' será
     * substituído pelo dado de contexto da chave 'foo'.
     *
     * O array com os dados de contexto pode ter dados arbitrários. A única
     * presunção que deve ser levada em consideração é que se uma instância de
     * Exception for informada para se produzir o stack trace, ela DEVERÁ estar
     * na chave de nome 'exception'.
     *
     * @param string               $level   nível do log
     * @param string|\Stringable   $message sobre o ocorrido
     * @param array<string, mixed> $context dados de contexto
     *
     * @return void
     *
     * @see https://www.php-fig.org/psr/psr-3/
     * @see https://www.php.net/manual/en/function.array-merge.php
     */
    private function log(string $level, string|\Stringable $message, ?array $context)
    {
        Log::log(
            level: $level,
            message: $message,
            context: $context + [
                'arquivo' => $this->arquivo,
                'nome_no' => $this->nome_no,
                'rules' => $this->rules,
                'max_upsert' => $this->max_upsert,
                'unique' => $this->unique,
                'atualizar_campos' => $this->atualizar_campos,
            ]
        );
    }
}
