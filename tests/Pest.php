<?php

use FruiVita\Corporativo\Tests\TestCase;
use Illuminate\Support\Facades\Storage;

uses(TestCase::class)->in('Feature', 'Unit');

uses()
->beforeEach(function () {
    $template = require __DIR__ . '/template/Corporativo.php';
    $xml = (new \SimpleXMLElement($template))->asXML();

    $this->file_system = Storage::fake('corporativo', [
        'driver' => 'local',
    ]);
    $this->file_system->put('fake_arquivo_corporativo.xml', $xml);

    // caminho completo para o arquivo corporativo que será importado
    $this->arquivo = $this->file_system->path('fake_arquivo_corporativo.xml');
})->in('Feature/Importadores');
