<?php

namespace Tests\Domain\Account\Projectors;

use Illuminate\Support\Facades\Auth;

use App\Domain\Account\AccountAggregateRoot;
use App\Models\Account;
use Tests\TestCase;

class AccountProjectorTest extends TestCase
{
    public function test_open_account(): void
    {
       $this->assertDatabaseHas((new Account())->getTable(), [
			'user_id' => $this->debitor_user->id,
			'account_uuid' => $this->debitor_account->account_uuid,
		]);

		$this->assertSame($this->debitor_user->id,$this->debitor_account->user_id)
    }

    public function test_deposit_funds(): void
    {
        $this->assertEquals(100.01,$this->debitor_account->balance);
 		
		$accountAggRootObject = new AccountAggregateRoot();
		
		$accountAggRootObject->depositFunds(10.00)->persist();
 
		$this->debitor_account->refresh();
 
		$this->assertEquals(110.01,$this->debitor_account->balance);
    }

    public function test_withdraw_funds(): void
    {
		$this->assertEquals(110.01,$this->debitor_account->balance);
		
		$accountAggRootObject = new AccountAggregateRoot();
 		
		$accountAggRootObject->withdrawFunds(10.00)->persist();
 
		$this->debitor_account->refresh();
		
		$this->assertEquals(100.01,$this->debitor_account->balance);
       
    }

    public function test_change_overdraft_limit(): void
    {
		$this->assertEquals(10,$this->debitor_account->overdraft);
		
		$accountAggRootObject = new AccountAggregateRoot();

		$accountAggRootObject->changeOverdraftLimit(20)->persist();
 
		$this->debitor_account->refresh();		

		$this->assertEquals(20,$this->debitor_account->overdraft);
    }

    public function test_close_account(): void
    {
        $debitor_account = Account::where('account_uuid','1af219db-6593-4993-8b9d-29a1c00c85b3')->first();
		
		$debitor_account->balance = 0;
 
		$debitor_account->save();
		
		$accountAggRootObject = new AccountAggregateRoot();
		
		$accountAggRootObject->closeAccount()->persist();
    
		$this->assertDatabaseMissing((new Account())->getTable(), [
			'account_id' => '1af219db-6593-4993-8b9d-29a1c00c85b3',
		]);
    }
}
