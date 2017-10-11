<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLivros extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('livros', function (Blueprint $table) {
            $table->increments('id');
            $table->string('isbn')->unique();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->integer('quantidade')->default(1);
            $table->integer('ano');
            $table->string('edicao')->nullable();
            $table->unsignedInteger('secao_id')->references('id')->on('secoes');
            $table->unsignedInteger('editora_id')->references('id')->on('editoras');

            $table->timestamps();
        });

        Schema::create('autor_livros', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('livro_id')->references('id')->on('livros');
            $table->unsignedInteger('autor_id')->references('id')->on('autores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('livros');
    }
}
