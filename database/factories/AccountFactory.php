<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;

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

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {		
		  return [
            'account_uuid' => fake()->uuid(),
            'balance' => fake()->randomFloat(2,1000,2000),
            'overdraft' => fake()->numberBetween(0,200),
			      'user_id' =>  User::factory(),
        ];
    }
}
