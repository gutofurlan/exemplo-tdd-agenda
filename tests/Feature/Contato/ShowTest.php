<?php

namespace Tests\Feature\Contato;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTest extends TestCase
{
    protected $url = '/api/contato/';

    /**
     * Executa um teste buscar de show inexistente
     * aguarda erro 404
     *
     * @return void
     */
    public function testNotFound() : void
    {
        $response = $this->json(
            'GET',
            $this->url . 333777333777,
            [],
            []
        );

        $response->assertStatus(404);
    }

    /**
     * Executa um teste de index
     * no DB, gerados pela seed
     *
     * @return void
     */
    public function testIndex() : void
    {
        $response = $this->json(
            'GET',
            $this->url,
            [],
            []
        );

        //verifica status da resposta
        $response->assertJson([
            'contatos'       => true,
        ])->assertStatus(200)
        ->assertHeader('Content-Type', 'application/json');

    }

    /**
     * Executa um teste de show
     * no DB, gerados pela seed
     *
     * @return void
     */
    public function testShow() : void
    {
        $response = $this->json(
            'GET',
            $this->url . 1,
            [],
            []
        );

        //verifica status da resposta
        $response->assertJson([
            'contato'       => true,
        ])->assertStatus(200)
        ->assertHeader('Content-Type', 'application/json');
    }
}
