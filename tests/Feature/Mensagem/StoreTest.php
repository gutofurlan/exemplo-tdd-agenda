<?php

namespace Tests\Feature\Mensagem;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;

class StoreTest extends TestCase
{
    protected $url = '/api/mensagem/';
    protected $table_name = 'mensagems';

    /**
     * Executa um teste de insert base gerada pelo seed
     * passando todos os parametros possiveis.
     *
     * @return void
     */
    public function testInsert() : void
    {
        $content = [
            'contato_id'    => 1,
            'mensagem'      => Str::random(10),
        ];

        $response = $this->json(
            'POST',
            $this->url,
            $content,
            []
        );

        $response->assertJson([
            'mensagem' => true,
        ])->assertStatus(201)
        ->assertHeader('Content-Type', 'application/json')
        ->assertJsonFragment([
            "mensagem"      => $content['mensagem'],
            "contato_id"    => $content['contato_id'],
        ]);

        //valida e inseriou no DB
        $this->assertDatabaseHas($this->table_name, $content);

    }



    /**
     * Executa um teste de insert base gerada pelo seed
     * nao passando mensagem.
     *
     * @return void
     */
    public function testInsertErrorValidateNoPassMensagem() : void
    {
        $content = [
            'contato_id'    => 1,
        ];

        $response = $this->json(
            'POST',
            $this->url,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(422);
    }

    /**
     * Executa um teste de insert base gerada pelo seed
     * nao passando contato_id.
     *
     * @return void
     */
    public function testInsertErrorValidateNoPassContato_id() : void
    {
        $content = [
            'mensagem'      => Str::random(10),
        ];

        $response = $this->json(
            'POST',
            $this->url,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(422);

        //valida se NAO inseriu
        $this->assertDatabaseMissing($this->table_name, $content);
    }

    /**
     * Executa um teste de insert base gerada pelo seed
     * nao passando um contato_id nao existente.
     *
     * @return void
     */
    public function testInsertErrorValidateContatoIdNotFound() : void
    {
        $content = [
            'contato_id'    => 333777,
            'mensagem'      => Str::random(10),
        ];

        $response = $this->json(
            'POST',
            $this->url,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(422);

        //valida se NAO inseriu
        $this->assertDatabaseMissing($this->table_name, $content);
    }
}
