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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained();
            $table->string('partnerCode')->nullable();
            $table->string('requestId')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->string('orderInfo')->nullable();
            $table->string('orderType')->nullable();
            $table->string('message')->nullable();
            $table->string('transId')->nullable();
            $table->string('payType')->nullable();
            $table->string('signature')->nullable();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
