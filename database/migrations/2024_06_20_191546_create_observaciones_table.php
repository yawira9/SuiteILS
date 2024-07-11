<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObservacionesTable extends Migration
{
    public function up()
    {
        Schema::create('observaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buque_id');
            $table->unsignedBigInteger('equipo_id');
            $table->integer('pregunta')->nullable();
            $table->text('observacion');
            $table->timestamps();

            $table->foreign('buque_id')->references('id')->on('buques')->onDelete('cascade');
            $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('observaciones');
    }
}