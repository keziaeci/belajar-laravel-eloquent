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
        Schema::create('wallets', function (Blueprint $table) {
            // $table->id();
            $table->string('id', 100)->nullable(false)->primary();
            $table->string('customer_id', 100);
            $table->bigInteger('amount')->nullable(false)->default(0);
            $table->foreign('customer_id')->on('customers')->references('id');
            // $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
