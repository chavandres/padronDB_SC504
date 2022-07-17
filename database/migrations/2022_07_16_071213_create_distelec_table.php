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
        Schema::create('distelec', function (Blueprint $table) {
            $table->id('Codelec')->unique();
            $table->string('Provincia', 10);
            $table->string('Canton', 30);
            $table->string('Distrito', 80);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('distelec');
    }
};
