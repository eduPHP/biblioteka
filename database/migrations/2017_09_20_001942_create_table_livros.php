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
