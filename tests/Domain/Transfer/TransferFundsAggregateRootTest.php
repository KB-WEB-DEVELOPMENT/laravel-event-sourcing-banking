<?php
namespace Tests\Domain\Transfer;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

use App\Domain\Transfer\Events\FundsTransferred;

use App\Domain\Transfer\TransferFundsAggregateRoot;

use App\Models\User;
use App\Models\Account;

class TransferFundsAggregateRootTest
{
    protected User $debitor_user;
	protected User $creditor_user;
	protected Account $debitor_account;
	protected Account $creditor_account;
	protected TransferFundsAggregateRoot $transferFundsAggregateRoot;

    public function setUp(): void
    {		
		/*
		   The precautionary steps below are necessary because the transfer funds related main event 
		  (transfer funds) can only be carried out by the logged in debitor user on from his/her debitor account
 		    and the money transferred to an existing creditor account. 
		*/  
		  		
		$this->debitor_user = Auth::user();
		
		$this->creditor_user =  User::factory()->create([
										'name' => 'firstname lastname',
										'email' => 'name@bank.com',
								]);
		
		if (Account::where('user_id',$this->debitor_user->id)->exists()) {
			Account::where('user_id',$this->debitor_user->id)->delete();	
		}

		$this->debitor_account = Account::factory()->create([
									'user_id' => $this->debitor_user->id,
								]);
		
		$this->creditor_account = Account::factory()->create([
									'user_id' => $this->creditor_user->id
								]);
		
		$any_uuid = Str::uuid();
		
		$this->transferFundsAggregateRoot = new  TransferFundsAggregateRoot::fake($any_uuid); 
    }
	
    public function can_transfer_funds(): void
    {
		$this->transferFundsAggregateRoot
		            ->given([])
				    ->when(function(): void {
						$this->transferFundsAggregateRoot->transferFunds(9.99,$this->creditor_account->account_uuid);
					})
					->assertRecorded([
						new FundsTransferred(9.99,$this->creditor_account->account_uuid)
					]);        
    }
	
    
}