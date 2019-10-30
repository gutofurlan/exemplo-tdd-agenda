<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMensagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mensagems', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->bigInteger('contato_id')->unsigned();

            $table->text('mensagem');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('contato_id')->references('id')->on('contatos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mensagems');
    }
}
