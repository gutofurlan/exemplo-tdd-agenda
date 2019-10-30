<?php

use Illuminate\Database\Seeder;

use App\Models\Contato;

class ContatoSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Contato::create([
            'nome'          => 'Augusto',
            'sobrenome'     => 'Furlan',
            'email'        => 'gulyfurlan@gmail.com',
            'telefone'      => '19997797781'
        ]);

        Contato::create([
            'nome'          => 'Nome',
            'sobrenome'     => 'Sobrenome',
            'email'        => 'email@gmail.com',
            'telefone'      => '11999999999'
        ]);
    }
}
