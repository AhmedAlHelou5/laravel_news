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
         Schema::create('news', function (Blueprint $table) {
                    $table->id();
//                   $table->enum('log_type',['login','logout']);
                    $table->string('title')->nullable();
                    $table->string('description')->nullable();
                    $table->dateTime('date')->nullable();
                    $table->string('photo')->nullable();
                    $table->unsignedBigInteger('classification_id');
                    $table->foreign('classification_id')->references('id')->on('classification')->cascadeOnDelete();
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
        //
    }
};
