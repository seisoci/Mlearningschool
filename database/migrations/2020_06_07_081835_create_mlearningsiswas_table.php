<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlearningsiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlearningsiswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_mlearning_id');
            $table->unsignedBigInteger('siswa_id');
            $table->timestamps();
            $table->foreign('kelas_mlearning_id')->references('id')->on('mlearningkelas')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mlearningsiswas');
    }
}
