<?php

namespace App\Domain\Account;

use Illuminate\Support\Facades\Auth;

use App\Domain\Account\Exceptions\CouldNotDepositFundsException;
use App\Domain\Account\Exceptions\CouldNotWithdrawFundsException;
use App\Domain\Account\Exceptions\CouldNotChangeOverdraftLimitException;
use App\Domain\Account\Exceptions\CouldNotCloseAccountException;

use App\Domain\Account\Events\AccountOpened;
use App\Domain\Account\Events\FundsDeposited;
use App\Domain\Account\Events\FundsWithdrawn;
use App\Domain\Account\Events\OverdraftLimitChanged;
use App\Domain\Account\Events\OverdraftLimitReached;
use App\Domain\Account\Events\AccountClosed;

use App\Models\Account;

use App\Mail\LoanProposalMail;

use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class AccountAggregateRoot extends AggregateRoot
{	
	public function openAccount(): self
    {
        $this->recordThat(new AccountOpened());

        return $this;
    }

    public function depositFunds(float $amount):self
    {
        $amount = round($amount,2);
		
		if ($amount === round(0,2)) {
			throw CouldNotDepositFundsException::printZeroDepositMessage();
		}
		
		if ($amount < round(0,2)) {
			throw CouldNotDepositFundsException::printNegativeDepositMessage();
		}
		
		$this->recordThat(new FundsDeposited($amount));

        return $this;
    }
	
	public function withdrawFunds(float $amount):self
    {		
		$amount = round($amount,2);
		
		if ($amount === round(0,2)) {
			throw CouldNotWithdrawFundsException::withdrawalAmountEqualsZero();
		}	
		
		if ($amount < round(0,2)) {
			throw CouldNotWithdrawFundsException::withdrawalAmountNegative();
		}
					
		$user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->firstOrFail();
				
		$available_funds = $account->balance + round($account->overdraft,2);

		if (($available_funds < $amount) && ($this->isOverdraftSet() == false)) {
			
			$overdrawn_amount = abs($available_funds - $amount);
			
			throw CouldNotWithdrawFundsException::insufficientFunds($overdrawn_amount);
		}

		if (($available_funds < $amount) && ($this->isOverdraftSet() == true)) {
			
			$this->recordThat(new OverdraftLimitReached());
			
			throw CouldNotWithdrawFundsException::overdraftReached();
		}		

		$this->recordThat(new FundsWithdrawn($amount));

        return $this;
    }
	
	public function changeOverdraftLimit(int $overdraft):self
    {
        if ($overdraft === 0) {
			throw CouldNotChangeOverdraftLimitException::printZeroOverdraftMessage();
		}
		
		if ($overdraft < 0) {
			throw CouldNotChangeOverdraftLimitException::printNegativeOverdraftMessage();
		}
		
		$this->recordThat(new OverdraftLimitChanged($overdraft));

        return $this;
    }
	
	public function closeAccount():self
    {
         if ($this->isAccountyEmpty() == false) {
			 
			throw CouldNotCloseAccountException::printNonEmptyMessage();
		}
		
		$this->recordThat(new AccountClosed());

        return $this;		
    }
	
	public function isOverdraftSet(): bool
    {
		$user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->firstOrFail();
		
		return $account->overdraft > 0;	
    }
	
	public function isAccountEmpty(): bool
    {
		$user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->firstOrFail();	
		
		return $account->balance ===  round(0,2);	
    }	
}
