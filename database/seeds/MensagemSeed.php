<?php

use Illuminate\Database\Seeder;

use App\Models\Mensagem;

class MensagemSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Mensagem::create([
            'contato_id' => 1,
            'mensagem'   => 'Mensagem 1'
        ]);

        Mensagem::create([
            'contato_id' => 2,
            'mensagem'   => 'Mensagem 2'
        ]);
    }
}
