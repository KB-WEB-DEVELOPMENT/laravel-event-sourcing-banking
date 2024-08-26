<?php

namespace Tests;

use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Account;
use App\Models\TransferFund;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Throwable;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected User $debitor_user;
	protected User $creditor_user;
	
    protected Account $debitor_account;
	protected Account $creditor_account;

	protected TransferFund $transfer_fund;

    public function setUp(): void
    {
        
		$this->debitor_user =  User::factory()->create([
									'name' => 'debitorTest',
									'email' => 'debitor@yahoo.com',
								]);
		
		$this->creditor_user =  User::factory()->create([
									'name' => 'creditorTest',
									'email' => 'creditor@yahoo.com',
								]);
																
		$this->debitor_account =  Account::factory()->create([
									'account_uuid' => '1af219db-6593-4993-8b9d-29a1c00c85b3',
									'balance' => 100.01,
									'overdraft' => 10,
									'user_id' => Auth::id(),
								]);					
			
		$this->creditor_account = Account::factory()->create([
									'account_uuid' => '9897a490-2cfd-4943-86ce-d287bf04342f',
									'balance' => 1.00,
									'user_id' => $this->creditor_user->id,
								]);
												
		// rem: I am using a different $debitor_account_uuid here just for testing purposes
		$this->transfer_fund =  TransferFund::factory()->create([
									'debitor_account_uuid' => '399148fa-a133-4b0f-ac84-93fd9427eb0b',
									'creditor_account_uuid' => '9897a490-2cfd-4943-86ce-d287bf04342f',
									'amount' => 2.01,
								]);
		parent::setUp();
       
    }

    protected function assertExceptionThrown(callable $callable, string $expectedExceptionClass): void
    {
        try {
            $callable();

            $this->assertTrue(false, "Expected exception `{$expectedExceptionClass}` was not thrown.");
        } catch (Throwable $exception) {
            if (! $exception instanceof $expectedExceptionClass) {
                throw $exception;
            }
            $this->assertInstanceOf($expectedExceptionClass, $exception);
        }
    }
}
