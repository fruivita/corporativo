<?php

namespace FruiVita\Corporativo\Importadores\Contracts;

interface IImportavel
{
    /**
     * Executa a importação.
     *
     * @param  string  $arquivo caminho completo para o arquivo XML que será
     *                        importado
     * @return void
     */
    public function importar(string $arquivo);
}
