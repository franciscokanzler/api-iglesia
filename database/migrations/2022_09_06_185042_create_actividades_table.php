<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',45);
            $table->text('descripcion')->nullable();
            $table->string('lugar',100);
            $table->date('fecha_inicio');
            $table->date('fecha_culminacion');
            $table->time('hora_inicio');
            $table->time('hora_culminacion');

            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->unsignedBigInteger('estatus_id');

            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('estatus_id')->references('id')->on('estatus');

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
        Schema::dropIfExists('actividades');
    }
};
