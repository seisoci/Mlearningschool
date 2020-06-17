<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMlearningmaterisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mlearningmateris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kelas_mlearning_id');
            $table->string('judul');
            $table->string('image')->nullable();
            $table->string('image_2')->nullable();
            $table->string('image_3')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
            $table->foreign('kelas_mlearning_id')->references('id')->on('mlearningkelas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mlearningmateris');
    }
}
