<?php

return [
    /*
    |-------------------------------------------------------------------------
    | Log Completo
    |-------------------------------------------------------------------------
    |
    | Esse package gera log para 04 cenários:
    | 1. Início da importação
    | 2. Fim da importação
    | 3. Falha na importação
    | 4. Falhas de validação/inconsistência dos dados
    |
    | Se log_completo for true, todos os cenários acima serão registrados em
    | log.
    | Útil para monitorar se o processo de importação está funcionando como
    | esperado.
    | Se false, não registrará os cenários 1 e 2, mas continua registrando os
    | demais.
    |
    */

    'log_completo' => true,

    /*
    | ------------------------------------------------------------------------
    | Max Upsert
    | ------------------------------------------------------------------------
    |
    | Número de registros que serão persistidos no banco de dados por query.
    |
    | Se menor ou igual a zero, utilizará o valor padrão internamente definido.
    |
    */
    'max_upsert' => 500,
];
