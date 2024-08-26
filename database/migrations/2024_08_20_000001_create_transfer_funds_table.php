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
    public function up(): void
    {
	   Schema::create('transfer_funds', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('debitor_account_uuid');
			$table->foreign('debitor_account_uuid')->references('account_uuid')->on('accounts');
			$table->unsignedBigInteger('creditor_account_uuid');
			$table->foreign('creditor_account_uuid')->references('account_uuid')->on('accounts');
			$table->float('amount',8,2)->default(0.01);
            $table->rememberToken();
            $table->timestamps();
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_funds');
    }
}
