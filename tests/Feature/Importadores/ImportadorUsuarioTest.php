<?php

/**
 * @see https://pestphp.com/docs/
 * @see https://laravel.com/docs/9.x/mocking
 */

use FruiVita\Corporativo\Events\CargoUsuarioAlterado;
use FruiVita\Corporativo\Events\FuncaoConfiancaUsuarioAlterada;
use FruiVita\Corporativo\Events\LotacaoUsuarioAlterada;
use FruiVita\Corporativo\Importadores\ImportadorCargo;
use FruiVita\Corporativo\Importadores\ImportadorFuncaoConfianca;
use FruiVita\Corporativo\Importadores\ImportadorLotacao;
use FruiVita\Corporativo\Importadores\ImportadorUsuario;
use FruiVita\Corporativo\Models\Cargo;
use FruiVita\Corporativo\Models\FuncaoConfianca;
use FruiVita\Corporativo\Models\Lotacao;
use FruiVita\Corporativo\Models\Usuario;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

// Falhas
test('cria os logs para cada usuário inválido', function () {
    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);

    Log::spy();

    ImportadorUsuario::make()->importar($this->arquivo);

    Log::shouldHaveReceived('log')
        ->withArgs(fn ($level, $message) => $level === 'warning' && $message === __('Validação falhou'))
        ->times(14);

    expect(Usuario::count())->toBe(5);
});

// Caminho feliz
test('make retorna oobjeto da classe', function () {
    expect(ImportadorUsuario::make())->toBeInstanceOf(ImportadorUsuario::class);
});

test('importa os usuários do arquivo corporativo', function () {
    // força a execução de duas queries em pontos diferentes para testá-las
    config(['corporativo.max_upsert' => 2]);

    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);
    ImportadorUsuario::make()->importar($this->arquivo);

    $usuarios = Usuario::get();

    expect($usuarios)->toHaveCount(5)
        ->and($usuarios->pluck('nome'))->toMatchArray(['Pessoa 1', 'Pessoa 2', 'Pessoa 3', 'Pessoa 4', 'Pessoa 5']);
});

test('emite evento CargoUsuarioAlterado se for identificada alteração no cargo do usuário durante a importação', function () {
    config(['corporativo.eventos' => true]);

    Event::fake();

    $cargo_anterior = Cargo::factory()->create(['id' => 5000]);

    $usuario = Usuario::factory()->create([
        'matricula' => '22222',
        'cargo_id' => $cargo_anterior->id,
    ]);

    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);
    ImportadorUsuario::make()->importar($this->arquivo);

    $usuario->refresh();

    Event::assertDispatched(function (CargoUsuarioAlterado $event) use ($cargo_anterior, $usuario) {
        expect($event->usuario)->toBe($usuario->id)
            ->and($event->cargo_anterior)->toBe($cargo_anterior->id)
            ->and($event->cargo_atual)->toBe($usuario->cargo_id);

        return true;
    });
});

test('emite evento FuncaoConfiancaUsuarioAlterada se for identificada alteração na função de confiança do usuário durante a importação', function () {
    config(['corporativo.eventos' => true]);

    Event::fake();

    $funcao_anterior = FuncaoConfianca::factory()->create(['id' => 5000]);

    $usuario = Usuario::factory()->create([
        'matricula' => '44444',
        'funcao_confianca_id' => $funcao_anterior->id,
    ]);

    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);
    ImportadorUsuario::make()->importar($this->arquivo);

    $usuario->refresh();

    Event::assertDispatched(function (FuncaoConfiancaUsuarioAlterada $event) use ($funcao_anterior, $usuario) {
        expect($event->usuario)->toBe($usuario->id)
            ->and($event->funcao_anterior)->toBe($funcao_anterior->id)
            ->and($event->funcao_atual)->toBe($usuario->funcao_confianca_id);

        return true;
    });
});

test('emite evento LotacaoUsuarioAlterada se for identificada alteração na lotação do usuário durante a importação', function () {
    config(['corporativo.eventos' => true]);

    Event::fake();

    $lotacao_anterior = Lotacao::factory()->create(['id' => 5000]);

    $usuario = Usuario::factory()->create([
        'matricula' => '44444',
        'lotacao_id' => $lotacao_anterior->id,
    ]);

    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);
    ImportadorUsuario::make()->importar($this->arquivo);

    $usuario->refresh();

    Event::assertDispatched(function (LotacaoUsuarioAlterada $event) use ($lotacao_anterior, $usuario) {
        expect($event->usuario)->toBe($usuario->id)
            ->and($event->lotacao_anterior)->toBe($lotacao_anterior->id)
            ->and($event->lotacao_atual)->toBe($usuario->lotacao_id);

        return true;
    });
});

test('concatena (prepend) a chave de configuração matrícula à matrícula do usuário importada do arquivo corporativo', function () {
    config(['corporativo.matricula' => 'foo']);

    ImportadorCargo::make()->importar($this->arquivo);
    ImportadorFuncaoConfianca::make()->importar($this->arquivo);
    ImportadorLotacao::make()->importar($this->arquivo);
    ImportadorUsuario::make()->importar($this->arquivo);

    $usuario = Usuario::firstWhere('email', 'p1@p1.com');

    expect($usuario->matricula)->toBe('foo11111');
});
