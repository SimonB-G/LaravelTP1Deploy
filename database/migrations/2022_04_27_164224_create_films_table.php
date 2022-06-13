<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->year('release_year');
            $table->unsignedSmallInteger('length')->nullable();
            $table->text('description')->nullable();
            $table->string('rating', 255);
            $table->unsignedBigInteger('language_id');
            $table->string('special_features', 200)->nullable();
            $table->string('image', 40)->nullable();
            $table->timestamps();
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('films');
    }
}
