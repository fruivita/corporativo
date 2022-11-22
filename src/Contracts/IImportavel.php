<?php

namespace FruiVita\Corporativo\Contracts;

interface IImportavel
{
    /**
     * Executa a importação.
     *
     * Importa, na sequência abaixo, os seguintes modelos:
     * 1. Cargo
     * 2. Função de Confiança
     * 3. Lotação
     * 4. Usuário (Pessoa)
     *
     * @param  string  $arquivo caminho completo para o arquivo XML que será
     *                        importado
     * @return void
     *
     * @throws \FruiVita\Corporativo\Exceptions\FileNotReadableException
     * @throws \FruiVita\Corporativo\Exceptions\UnsupportedFileTypeException
     */
    public function importar(string $arquivo);
}
