<?php

namespace Tests\Feature\Contato;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;
use Str;

class UpdateTest extends TestCase
{
    protected $url = '/api/contato/';
    protected $table_name = 'contatos';

    /**
     * Executa um teste de update base gerada pelo seed
     * passando todos os parametros possiveis.
     *
     * @return void
     */
    public function testupdate() : void
    {
        $old_data = DB::table($this->table_name)->whereId(1)->first();
        $content = [
            'id'              => 1,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
        ];

        $response = $this->json(
            'PUT',
            $this->url . 1,
            $content,
            []
        );

        $response->assertJson([
            'data' => true,
        ])->assertStatus(200)
        ->assertHeader('Content-Type', 'application/json')
        ->assertJsonFragment([
            "nome"                  => $content['nome'],
            "sobrenome"             => $content['sobrenome'],
            "email"                 => $content['email'],
            "telefone"              => $content['telefone'],
        ]);

        //valida que nao existe o dado anterior
        $this->assertDatabaseMissing($this->table_name, (array) $old_data);

        //valida se atualizou no DB
        $this->assertDatabaseHas($this->table_name, $content);

    }



    /**
     * Executa um teste de update base gerada pelo seed
     * passando nome menor que  obrigatorio.
     *
     * @return void
     */
    public function testupdateErrorValidateNomeMin() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => 'N',
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * Executa um teste de update base gerada pelo seed
     * passando nome maior que  obrigatorio.
     *
     * @return void
     */
    public function testupdateErrorValidateNomeMax() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => Str::random(70),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * Executa um teste de update base gerada pelo seed
     * passando sobrenome menor que  obrigatorio.
     *
     * @return void
     */
    public function testupdateErrorValidateSobrenomeMin() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(1),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * Executa um teste de update base gerada pelo seed
     * passando sobrenome maior que  obrigatorio.
     *
     * @return void
     */
    public function testupdateErrorValidateSobrenomeMax() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(70),
            'email'           => $this->faker->email,
            "telefone"        => '11111111111',
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
     * Executa um teste de update base gerada pelo seed
     * passando email em outro formato.
     *
     * @return void
     */
    public function testupdateErrorValidateEmailNotValid() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => Str::random(10),
            "telefone"        => '11111111111',
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
     * Executa um teste de update base gerada pelo seed
     * nao passando email obrigatorio.
     *
     * @return void
     */
    public function testupdateErrorValidateEmailNotPass() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            "telefone"        => '11111111111',
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
     * Executa um teste de update base gerada pelo seed
     * nao passando telefone obrigatorio.
     *
     * @return void
     */
    public function testupdateErrorValidateTelefoneNotPass() : void
    {
        $content = [
            'id'              => 1,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email
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
     * Executa um teste de update base gerada pelo seed
     * idnao existente.
     *
     * @return void
     */
    public function testupdateErrorValidateNotFound() : void
    {
        $content = [
            'id'              => 333777,
            'nome'            => Str::random(10),
            'sobrenome'       => Str::random(10),
            'email'           => $this->faker->email
        ];

        $response = $this->json(
            'PUT',
            $this->url . 333777,
            $content,
            []
        );

        //verifica o retorno
        $response->assertJson([
            'message'       => true,
        ])->assertStatus(404);

        //valida se NAO atualizou
        $this->assertDatabaseMissing($this->table_name, $content);
    }
}
