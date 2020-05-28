<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('entrega')->nullable();
            $table->date('fecha')->nullable();
            $table->string('cbu_debito')->nullable();
            $table->string('cbu_credito')->nullable();
            $table->string('alias_cbu_debito')->nullable();
            $table->string('alias_cbu_credito')->nullable();
            $table->decimal('importe')->nullable();
            $table->string('concepto')->nullable();
            $table->text('motivo')->nullable();
            $table->string('referencia')->nullable();
            $table->string('email')->nullable();
            $table->string('titulares')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transferencias');
    }
}
