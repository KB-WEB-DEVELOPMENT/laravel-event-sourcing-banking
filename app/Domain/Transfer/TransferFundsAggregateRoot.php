<?php

namespace App\Domain\Transfer;

use Illuminate\Support\Facades\Auth;

use App\Domain\Transfer\Exceptions\AmountZeroException;
use App\Domain\Transfer\Exceptions\AmountNegativeException;
use App\Domain\Transfer\Exceptions\InsufficientFundsException;
use App\Domain\Transfer\Exceptions\CouldNotFindCreditorAccountException;
use App\Domain\Transfer\Exceptions\SameAccountsException;

use App\Domain\Transfer\Events\FundsTransferred;
use App\Domain\Transfer\Events\OverdraftLimitReached;

use App\Models\Account;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class TransferFundsAggregateRoot extends AggregateRoot
{
   
    public function transferFunds(float $amount,string $creditor_account_uuid): self
    {		
		if (
			 ($this->checkTransferAmount($amount) == true)  &&
			 ($this->checkSufficientFunds($amount) == true) &&
			 ($this->checkCreditor($creditor_account_uuid) == true) &&
			 ($this->checkDebitorOtherAsCreditor($creditor_account_uuid) == true)
		) {
			
			$this->recordThat(new FundsTransferred(round($amount,2),$creditor_account_uuid));

			return $this;
		}	
    }
   
	public function checkTransferAmount(float $amount): bool
    {		
		$amount = round($amount,2);
		
		if ($amount === round(0,2)) {
			throw AmountZeroException::printMessage();
		}
		
		if ($amount < round(0,2)) {
			throw AmountNegativeException::printMessage();
		}		
		return true;		
    }

  	public function checkSufficientFunds(float $amount): bool
    {     		
		$amount = round($amount,2);
		
		$user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->first();
		
		$available_funds = round($account->balance,2) + round($account->overdraft,2);

		if ($available_funds - $amount < round(0,2)) {
			
			$this->recordThat(new OverdraftLimitReached());
			
			throw InsufficientFundsException::printMessage($amount,round($account->balance,2),$account->overdraft);
		}
		return true;
    }
		
	public function checkCreditor(string $creditor_account_uuid): bool
    {  
		$found_creditor_account_uuid = Account::where('account_uuid',$creditor_account_uuid)->first()->account_uuid;
	 
		if (!$found_creditor_account_uuid) {
			throw CouldNotFindCreditorAccountException::printMessage($creditor_account_uuid);
		}		
		return true;
    }
	
	public function checkDebitorOtherAsCreditor(string $creditor_account_uuid): bool
    {
		$user_id = Auth::id();
		
		$debitor_account_uuid = Account::where('user_id',$user_id)->first()->account_uuid;
		
		$found_creditor_account_uuid = Account::where('account_uuid',$creditor_account_uuid)->first()->account_uuid;
		
		if ($debitor_account_uuid == $found_creditor_account_uuid) {
			throw SameAccountsException::printMessage($creditor_account_uuid);
		}		
		return true;
    }
}
