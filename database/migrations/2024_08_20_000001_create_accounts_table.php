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
		Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('account_uuid')->unique();
			$table->float('balance',8,2);
			$table->unsignedInteger('overdraft')->default(0);
            $table->rememberToken();
            $table->timestamps();
			$table->unsignedBigInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
}
