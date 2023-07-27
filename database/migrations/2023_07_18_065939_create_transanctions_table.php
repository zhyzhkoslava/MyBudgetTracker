<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transanctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->references('id')->on('accounts');
            $table->string('type');
            $table->integer('amount');
            $table->dateTime('date');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transanctions');
    }
};
