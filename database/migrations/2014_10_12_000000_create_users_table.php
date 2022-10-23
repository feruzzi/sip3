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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('name');
            $table->string('password');
            $table->string('group1')->index(); //umum
            $table->string('group2')->index(); //detailed
            $table->string('level'); // 1 => admin, 0=>siswa
            $table->string('status'); // 1 => aktif, 0=>nonaktif
            $table->foreign('group1')->references('group1_id')->on('group1')->restrictOnDelete()->restrictOnUpdate();
            $table->foreign('group2')->references('group2_id')->on('group2')->restrictOnDelete()->restrictOnUpdate();
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
        Schema::dropIfExists('users');
    }
};