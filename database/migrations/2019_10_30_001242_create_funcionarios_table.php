<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('nome');
			$table->unsignedBigInteger('imagem_id');
			$table->string('email');
			$table->string('cpf');
			$table->string('telefone');
			$table->text('observacoes');

			$table->foreign('imagem_id')->references('id')->on('imagens');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('funcionarios', function (Blueprint $table) {
			$table->dropForeign('funcionarios_imagem_id_foreign');
		});
        Schema::dropIfExists('funcionarios');
    }
}
