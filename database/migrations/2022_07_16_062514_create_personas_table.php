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
        Schema::create('personas', function (Blueprint $table) {
            $table->id('Cedula')->unique();
            $table->foreignId('Codelec');
            $table->string('VencCedula', 8);
            $table->string('JuntaReceptora', 5)->default('00000');
            $table->string('Nombre', 30);
            $table->string('PrimerApellido', 30);
            $table->string('SegundoApellido', 30);

            $table->foreign('Codelec')->references('Codelec')->on('Distelec');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personas');
    }
};
