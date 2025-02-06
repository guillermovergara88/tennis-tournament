<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['M', 'F']);
            $table->unsignedInteger('skill')->default(50);
            $table->unsignedInteger('strength')->default(50);
            $table->unsignedInteger('speed')->default(50);
            $table->unsignedInteger('reaction_time')->default(50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('players');
    }
};
