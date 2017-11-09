<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmprestimosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emprestimos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('estudante_id')->references('id')->on('estudantes');
            $table->unsignedInteger('livro_id')->references('id')->on('livros');
            $table->dateTime('devolucao');

            $table->dateTime('emprestado_em');
            $table->dateTime('devolvido_em')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emprestimos');
    }
}
