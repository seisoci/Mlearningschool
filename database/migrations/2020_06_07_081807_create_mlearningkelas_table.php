<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlearningkelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlearningkelas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guru_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('matapelajaran_id');
            $table->string('jurusan')->nullable();
            $table->integer('tahun');
            $table->timestamps();
            $table->foreign('guru_id')->references('id')->on('users');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->foreign('matapelajaran_id')->references('id')->on('matapelajarans');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mlearningkelas');
    }
}
