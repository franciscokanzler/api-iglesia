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
        Schema::create('miembros', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',45);
            $table->string('apellido',45);
            $table->date('fecha_nacimiento');
            $table->string('ci',45)->unique()->nullable();
            $table->integer('edad');
            $table->string('telefono',10)->nullable();
            $table->string('correo',45)->unique()->nullable();
            $table->integer('nro_casa')->nullable();
            $table->string('calle',45)->nullable();
            $table->integer('id_representante')->nullable();

            $table->unsignedBigInteger('iglesia_id')->nullable();
            $table->unsignedBigInteger('rango_id')->nullable();
            $table->unsignedBigInteger('estado_civil_id')->nullable();
            $table->unsignedBigInteger('estado_id');
            $table->unsignedBigInteger('municipio_id');
            $table->unsignedBigInteger('parroquia_id');

            $table->foreign('iglesia_id')->references('id')->on('iglesias')->onDelete('set null');
            $table->foreign('rango_id')->references('id')->on('rangos')->onDelete('set null');
            $table->foreign('estado_civil_id')->references('id')->on('estados_civiles')->onDelete('set null');
            /* $table->foreign('estado_id')->references('id')->on('estados');
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('parroquia_id')->references('id')->on('parroquias'); */

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
        Schema::dropIfExists('miembros');
    }
};
