<?php

namespace Tests\Feature\Contato;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;
use Str;

class StoreTest extends TestCase
{
    protected $url = '/api/contato/';
    protected $table_name = 'contatos';

    /**
     * Executa um teste de insert base gerada pelo seed
     * passando todos os parametros possiveis.
     *
     * @return void
     */
    public function testInsert() : void
    {
        $content = [
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
        ];

        $response = $this->json(
            'POST',
            $this->url,
            $content,
            []
        );

        $response->assertJson([
            'contato' => true,
        ])->assertStatus(201)
        ->assertHeader('Content-Type', 'application/json')
        ->assertJsonFragment([
            "nome"                  => $content['nome'],
            "sobrenome"             => $content['sobrenome'],
            "email"                 => $content['email'],
            "telefone"              => $content['telefone'],
        ]);

        //valida e inseriou no DB
        $this->assertDatabaseHas($this->table_name, $content);

    }



    /**
     * Executa um teste de insert base gerada pelo seed
     * passando nome menor que  obrigatorio.
     *
     * @return void
     */
    public function testInsertErrorValidateNomeMin() : void
    {
        $content = [
            'nome'            => 'N',
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * passando nome maior que  obrigatorio.
     *
     * @return void
     */
    public function testInsertErrorValidateNomeMax() : void
    {
        $content = [
            'nome'            => Str::random(70),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * passando sobrenome menor que  obrigatorio.
     *
     * @return void
     */
    public function testInsertErrorValidateSobrenomeMin() : void
    {
        $content = [
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(1),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * passando sobrenome maior que  obrigatorio.
     *
     * @return void
     */
    public function testInsertErrorValidateSobrenomeMax() : void
    {
        $content = [
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(70),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * passando email em outro formato.
     *
     * @return void
     */
    public function testInsertErrorValidateEmailNotValid() : void
    {
        $content = [
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => Str::random(10),
            "telefone"        => '11111111111',
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
     * nao passando email obrigatorio.
     *
     * @return void
     */
    public function testInsertErrorValidateEmailNotPass() : void
    {
        $content = [
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            "telefone"        => '11111111111',
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
     * nao passando telefone obrigatorio.
     *
     * @return void
     */
    public function testInsertErrorValidateTelefoneNotPass() : void
    {
        $content = [
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email
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
