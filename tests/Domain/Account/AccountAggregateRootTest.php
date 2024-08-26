<?php
namespace Tests\Domain\Account;

use App\Domain\Account\Events\AccountOpened;
use App\Domain\Account\Events\FundsDeposited;
use App\Domain\Account\Events\FundsWithdrawn;
use App\Domain\Account\Events\OverdraftLimitChanged;
use App\Domain\Account\Events\AccountClosed;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Domain\Account\AccountAggregateRoot;

use App\Models\User;
use App\Models\Account;

class AccountAggregateRootTest
{
    protected User $user;
	protected AccountAggregateRoot $accountAggregateRoot;

    public function setUp(): void
    {		
		/*
		   The precautionary steps below are necessary because all account related events 
		  (open account, deposit funds, withdraw funds, update overdraft limit, close account) 
		  can only be carried out by the logged in user on his/her account
		*/  
		  		
		$this->user = Auth::user();
				
		if (Account::where('user_id',$this->user->id)->exists()) {
			Account::where('user_id',$this->user->id)->delete();	
		}	
		
		$any_uuid = Str::uuid();
		
		$this->accountAggregateRoot = new  AccountAggregateRoot::fake($any_uuid); 
    }
	
    public function can_open_account(): void
    {
		$this->accountAggregateRoot
		            ->given([])
				    ->when(function(): void {
						$this->accountAggregateRoot->openAccount();
					})
					->assertRecorded([
						new AccountOpened()
					]);        
    }
	
    public function can_deposit_funds(): void
    {        
		$this->accountAggregateRoot
		            ->given([new AccountOpened()])
				    ->when(function(): void {
						$this->accountAggregateRoot->depositFunds(10.99);
					})
					->assertRecorded([
						new FundsDeposited(10.99)
					]);
    }

    public function can_withdraw_funds(): void
    {
		$this->accountAggregateRoot
		            ->given([new FundsDeposited(10.99)])
				    ->when(function(): void {
						$this->accountAggregateRoot->withdrawFunds(1.99);
					})
					->assertRecorded([
						new FundsWithdrawn(1.99)
					]);		
    }
	
    public function can_change_overdraft_limit(): void
    {
		$this->accountAggregateRoot
		            ->given([])
				    ->when(function(): void {
						$this->accountAggregateRoot->changeOverdraftLimit(99);
					})
					->assertRecorded([
						new OverdraftLimitChanged(99)
					]);		
	}

    public function can_close_account(): void
    {
		$this->accountAggregateRoot
		            ->given([new AccountOpened()])
				    ->when(function(): void {
						
						$account = Account::where('user_id',$this->user->id);
						$account->balance = round(0,2);
						$account->save();
						
						$this->accountAggregateRoot->closeAccount();				
					})
					->assertRecorded([
						new AccountClosed()
					]);	
    }
}