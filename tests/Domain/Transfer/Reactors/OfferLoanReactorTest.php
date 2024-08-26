<?php

namespace Tests\Domain\Transfer\Reactors;

use Illuminate\Support\Facades\Auth;

use App\Domain\Transfer\TransferFundsAggregateRoot;

use App\Domain\Account\Events\OverdraftLimitReached;

use Illuminate\Support\Facades\Mail;

use App\Mail\LoanProposalMail;

use Tests\TestCase;

class OfferLoanReactorTest extends TestCase
{
    public function test_send_loan_after_overdraft_reached(): void
    {
        // Note: All TransferFundsAggregateRoot class methods only apply to the logged in user. 
		$user = Auth::user();
		
		Mail::fake();
			
		$available_amount = round(1,2);
		
		$transferFundsAggRootObject = new TransferFundsAggregateRoot();
		
		$transferFundsAggRootObject->checkSufficientFunds($available_amount);
		
		Mail::assertNotSent(LoanProposalMail::class);
		
		$unavailable_amount = round(19999999999,2);
		
		$this->assertExceptionThrown(function () use ($transferFundsAggRootObject){
			
            $transferFundsAggRootObject->checkSufficientFunds($unavailable_amount);
        
		},InsufficientFundsException::class);
		
		Mail::assertSent(function (LoanProposalMail $mail) {
            return $mail->hasTo($user->email);
        });
    }
}
