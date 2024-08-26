<?php

namespace Database\Seeders;

use App\Models\Account;

use Illuminate\Database\Seeder;

class TransferFundSeeder extends Seeder
{
    public function run(): void
    {	
		$this->call([
            AccountSeeder::class,
        ]);

		TransferFund::factory()->create([
            'debitor_account_uuid' =>  '00643dd8-d888-4576-9839-9bef16e3cbda',
            'creditor_account_uuid' => 'd5e161f1-3e47-4d77-985d-a05558efc9ba',
			'amount' => 49.99,
        ]);

    }
}