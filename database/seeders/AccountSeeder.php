<?php

namespace Database\Seeders;

use App\Models\TransferFund;

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {	
		$this->call([
            UserSeeder::class,
        ]);

		$debitor_account_uuid  = '00643dd8-d888-4576-9839-9bef16e3cbda'; 
		$creditor_account_uuid = 'd5e161f1-3e47-4d77-985d-a05558efc9ba';		
		
		Account::factory()->create([
            'account_id' => $debitor_account_uuid,
			'balance' => 1999.99,
            'user_id' => 1,
        ]);

		Account::factory()->create([
            'account_id' => $creditor_account_uuid,
            'user_id' => 2,
        ]);

    }
}
