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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('username')->index();
            $table->string('payment_id')->index();
            $table->string('bill_id')->unique();
            $table->foreign('username')->references('username')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->foreign('payment_id')->references('payment_id')->on('payments')->restrictOnDelete()->restrictOnUpdate();
            $table->date('date');
            $table->string('bill_amount');
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
        Schema::dropIfExists('bills');
    }
};