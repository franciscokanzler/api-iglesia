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
        Schema::create('equipo_miembros', function (Blueprint $table) {
            /* $table->id(); */

            $table->unsignedBigInteger('equipo_id');
            $table->unsignedBigInteger('miembro_id');

            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
            $table->foreign('miembro_id')->references('id')->on('miembros')->onDelete('cascade');

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
        Schema::dropIfExists('equipo_miembros');
    }
};
