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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id');
            $table->string('username')->index();
            $table->string('bill_id')->index();
            $table->string('payment_id')->index();
            $table->foreign('username')->references('username')->on('users')->restrictOnDelete()->restrictOnUpdate();
            $table->foreign('bill_id')->references('bill_id')->on('bills')->restrictOnDelete()->restrictOnUpdate();
            $table->foreign('payment_id')->references('payment_id')->on('payments')->restrictOnDelete()->restrictOnUpdate();
            $table->string('pay');
            $table->string('note');
            $table->string('photo');
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
        Schema::dropIfExists('transactions');
    }
};