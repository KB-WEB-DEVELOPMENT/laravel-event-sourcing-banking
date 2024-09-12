<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {	
		User::factory()->create([
            'name' => 'debitor',
            'email' => 'debitor@bank.com',
        ]);

        User::factory()->create([
            'name' => 'creditor',
            'email' => 'creditor@bank.com',
        ]);
    }
}
