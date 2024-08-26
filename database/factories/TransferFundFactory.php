<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\TransferFund;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

class TransferFundFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = TransferFund::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {		
		$debitor_account =  Account::factory();
		$creditor_account = Account::factory();
		
		return [
            'debitor_account_uuid' => $debitor_account->account_uuid,
            'creditor_account_uuid' => $creditor_account->account_uuid,
            'amount' => fake()->randomFloat(2,200,400),
        ];
    }
}
