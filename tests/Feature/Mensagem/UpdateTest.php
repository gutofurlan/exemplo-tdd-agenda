<?php

namespace Tests\Feature\Mensagem;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Str;
use DB;

class UpdateTest extends TestCase
{
    protected $url = '/api/mensagem/';
    protected $table_name = 'mensagems';

    /**
     * Executa um teste de Update base gerada pelo seed
     * passando todos os parametros possiveis.
     *
     * @return void
     */
    public function testUpdate() : void
    {
        $old_data = DB::table($this->table_name)->whereId(1)->first();
        $content = [
            'id'            => 1,
            'contato_id'    => 1,
            'mensagem'      => Str::random(10),
        ];

        $response = $this->json(
            'PUT',
            $this->url . 1,
            $content,
            []
        );

        $response->assertJson([
            'mensagem' => true,
        ])->assertStatus(200)
        ->assertHeader('Content-Type', 'application/json')
        ->assertJsonFragment([
            "mensagem"      => $content['mensagem'],
            "contato_id"    => $content['contato_id'],
        ]);

        //valida que nao existe o dado anterior
        $this->assertDatabaseMissing($this->table_name, (array) $old_data);

        //valida que atualizou no DB
        $this->assertDatabaseHas($this->table_name, $content);

    }



    /**
     * Executa um teste de Update base gerada pelo seed
     * nao passando mensagem.
     *
     * @return void
     */
    public function testUpdateErrorValidateNoPassMensagem() : void
    {
        $content = [
            'id'            => 1,
            'contato_id'    => 1,
        ];

        $response = $this->json(
            'PUT',
            $this->url . 1,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(422);
    }

    /**
     * Executa um teste de Update base gerada pelo seed
     * nao passando contato_id.
     *
     * @return void
     */
    public function testUpdateErrorValidateNoPassContato_id() : void
    {
        $content = [
            'id'            => 1,
            'mensagem'      => Str::random(10),
        ];

        $response = $this->json(
            'PUT',
            $this->url . 1,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(422);

        //valida se NAO atualizou
        $this->assertDatabaseMissing($this->table_name, $content);
    }

    /**
     * Executa um teste de Update base gerada pelo seed
     * nao passando um contato_id nao existente.
     *
     * @return void
     */
    public function testUpdateErrorValidateContatoIdNotFound() : void
    {
        $content = [
            'id'            => 1,
            'contato_id'    => 333777,
            'mensagem'      => Str::random(10),
        ];

        $response = $this->json(
            'PUT',
            $this->url . 1,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(422);

        //valida se NAO atualizou
        $this->assertDatabaseMissing($this->table_name, $content);
    }
}
