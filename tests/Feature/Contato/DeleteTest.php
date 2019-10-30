<?php

namespace Tests\Feature\Contato;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class DeleteTest extends TestCase
{
    protected $url = '/api/contato/';
    protected $table_name = 'contatos';

    /**
     * Executa um teste de deletar
     * no DB, gerados pela seed
     *
     * @return void
     */
    public function testDelete() : void
    {
        $response = $this->json(
            'DELETE',
            $this->url . 1,
            [],
        );

        //valida se deletou do DB
        $this->assertSoftDeleted($this->table_name, [
            'id' => 1
        ]);
        $this->assertSoftDeleted('mensagems', [
            'contato_id' => 1
        ]);

        $response->assertStatus(204);

        //recupera
        DB::table($this->table_name)->whereId(1)->update([
            'deleted_at' => null
        ]);
        DB::table('mensagems')->where('contato_id', 1)->update([
            'deleted_at' => null
        ]);
    }

    /**
     * Executa um teste de deletar porem com id inexistente
     * no DB, gerados pela seed
     *
     * @return void
     */
    public function testDeleteFailIdNotExist() : void
    {
        $response = $this->json(
            'DELETE',
            $this->url . 333777333777,
            [],
        );

        $response->assertStatus(404);
    }

}
