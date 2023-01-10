<?php

/**
 * @see https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc.
 */

return <<<'XML'
<?xml version='1.0' encoding='UTF-8'?>
<base>
    <cargos>
        <!-- Cargos Válidos -->
        <cargo id="1" nome="Cargo 1"/>
        <cargo id="2" nome="Cargo 2"/>
        <cargo id="3" nome="Cargo 3"/>
        <!-- Cargos Inválidos -->
        <!-- Sem o ID -->
        <cargo nome="Cargo 4"/>
        <!-- ID nulo/vazio -->
        <cargo id="" nome="Cargo 5"/>
        <!-- ID menor ou igual a zero -->
        <cargo id="0" nome="Cargo 6"/>
        <!-- Sem o nome -->
        <cargo id="7"/>
        <!-- Nome nulo/vazio -->
        <cargo id="8" nome=""/>
        <!-- Nome com mais de 255 caracteres -->
        <cargo id="9" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4"/>
    </cargos>
    <funcoes>
         <!-- Funções Válidas -->
        <funcao id="1" nome="Função 1"/>
        <funcao id="2" nome="Função 2"/>
        <funcao id="3" nome="Função 3"/>
        <!-- Funções Inválidas -->
        <!-- Sem o ID -->
        <funcao nome="Função 4"/>
        <!-- ID nulo/vazio -->
        <funcao id="" nome="Função 5"/>
        <!-- ID menor ou igual a zero -->
        <funcao id="0" nome="Função 6"/>
        <!-- Sem o nome -->
        <funcao id="7"/>
        <!-- Nome nulo/vazio -->
        <funcao id="8" nome=""/>
        <!-- Nome com mais de 255 caracteres -->
        <funcao id="9" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4"/>
    </funcoes>
    <lotacoes>
         <!-- Lotações Válidas -->
        <lotacao id="1" nome="Lotação 1" sigla="Sigla 1"/>
        <lotacao id="2" nome="Lotação 2" sigla="Sigla 2" idPai=""/>
        <lotacao id="3" nome="Lotação 3" sigla="Sigla 3" idPai="1"/>
        <lotacao id="4" nome="Lotação 4" sigla="Sigla 4"/>
        <lotacao id="5" nome="Lotação 5" sigla="Sigla 5" idPai="1"/>
        <!-- Lotações Inválidas -->
        <!-- Sem o ID -->
        <lotacao nome="Lotação 6" sigla="Sigla 6" idPai="1"/>
        <!-- ID nulo/vazio -->
        <lotacao id="" nome="Lotação 7" sigla="Sigla 7"/>
        <!-- ID menor ou igual a zero -->
        <lotacao id="0" nome="Lotação 8" sigla="Sigla 8" idPai="1"/>
        <!-- Sem o nome -->
        <lotacao id="9" sigla="Sigla 9"/>
        <!-- Nome nulo/vazio -->
        <lotacao id="10" nome="" sigla="Sigla 10" idPai="1"/>
        <!-- Nome com mais de 255 caracteres -->
        <lotacao id="11" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4" sigla="Sigla 11"/>
        <!-- Sem o sigla -->
        <lotacao id="12" nome="Lotação 12" idPai="1"/>
        <!-- Sigla nulo/vazio -->
        <lotacao id="13" nome="Lotação 13" sigla=""/>
        <!-- Sigla com mais de 55 caracteres -->
        <lotacao id="14" nome="Lotação 14" sigla="X7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45" idPai="1"/>
    </lotacoes>
    <pessoas>
         <!-- Pessoas Válidas -->
        <pessoa id="1" nome="Pessoa 1" matricula="11111" email="p1@p1.com" cargo="1" lotacao="2" funcaoConfianca="1"/>
        <pessoa id="2" nome="Pessoa 2" matricula="22222" email="p2@p2.com" cargo="1" lotacao="2" funcaoConfianca="2"/>
        <pessoa id="3" nome="Pessoa 3" matricula="33333" email="p3@p3.com" cargo="1" lotacao="3" funcaoConfianca="2"/>
        <pessoa id="4" nome="Pessoa 4" matricula="44444" email="p4@p4.com" cargo="2" lotacao="3" funcaoConfianca=""/>
        <pessoa id="5" nome="Pessoa 5" matricula="55555" email="p5@p5.com" cargo="2" lotacao="3" funcaoConfianca=""/>
        <!-- Pessoas Inválidas -->
        <!-- Sem o nome -->
        <pessoa id="6" matricula="66666" email="p6@p6.com" cargo="1" lotacao="2" funcaoConfianca=""/>
        <!-- Nome nulo/vazio -->
        <pessoa id="7" nome="" matricula="77777" email="p7@p7.com" cargo="1" lotacao="2" funcaoConfianca=""/>
        <!-- Nome com mais de 255 caracteres -->
        <pessoa id="8" nome="F8WRcUYFTJKuA0ZJva5MX5FX7mnMeXqKVHHDsUqfs6nnGjWVi33A0AfziN8Z9ALD2GiQEgltl9Ucd45rs2TSA2jvqeLT2t60X5S3O4lt8j9ZURmSPm1LBvLXWcBmh4vLjORDuSH50SBcwzcZbaTTbxFqZI5k9LOqcw5VlRtqCox44sAFXKkKVms9KvnL9ltmvtRp63JxqpWrp81TuYcnXuPc2MALKWO9Dwxc8pxP6XWKsJ5M3qYVgib8OIEc00O4" matricula="77777" email="p7@p7.com" cargo="1" lotacao="2" funcaoConfianca=""/>
        <!-- Sem cargo -->
        <pessoa id="12" nome="Pessoa 12" matricula="12121" email="p12@p12.com" lotacao="2" funcaoConfianca=""/>
        <!-- Cargo nulo -->
        <pessoa id="13" nome="Pessoa 13" matricula="13131" email="p13@p13.com" cargo="" lotacao="2" funcaoConfianca=""/>
        <!-- Cargo inexistente -->
        <pessoa id="14" nome="Pessoa 14" matricula="14141" email="p14@p14.com" cargo="1000" lotacao="2" funcaoConfianca=""/>
        <!-- Sem lotação -->
        <pessoa id="15" nome="Pessoa 15" matricula="15151" email="p15@p15.com" cargo="1" funcaoConfianca=""/>
        <!-- Lotação nula -->
        <pessoa id="16" nome="Pessoa 16" matricula="16161" email="p16@p16.com" cargo="1" lotacao="" funcaoConfianca=""/>
        <!-- Lotação inexistente -->
        <pessoa id="17" nome="Pessoa 17" matricula="17171" email="p17@p17.com" cargo="1" lotacao="1000" funcaoConfianca=""/>
        <!-- Função inexistente -->
        <pessoa id="18" nome="Pessoa 18" matricula="18181" email="p18@p18.com" cargo="1" lotacao="2" funcaoConfianca="1000"/>
        <!-- Matrícula nula/vazia -->
        <pessoa id="19" nome="Pessoa 19" matricula="" email="p19@p19.com" cargo="1" lotacao="2" funcaoConfianca=""/>
        <!-- Matrícula com mais de 20 caracteres -->
        <pessoa id="20" nome="Pessoa 20" matricula="TJKuA0ZJva5MX5FX7mnMe" email="p20@p20.com" cargo="1" lotacao="2" funcaoConfianca=""/>
        <!-- Email inválido -->
        <pessoa id="21" nome="Pessoa 21" matricula="21212" email="p21@p21" cargo="1" lotacao="2" funcaoConfianca=""/>
        <pessoa id="22" nome="Pessoa 22" matricula="22022" email="p22p21" cargo="1" lotacao="2" funcaoConfianca=""/>
    </pessoas>
</base>
XML;
