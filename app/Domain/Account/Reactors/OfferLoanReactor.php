<?php

namespace App\Domain\Account\Reactors;

use Illuminate\Support\Facades\Auth;

use App\Models\Account;

use App\Domain\Account\Events\OverdraftLimitReached;

use App\Mail\LoanProposalMail;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;

use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class OfferLoanReactor extends Reactor implements ShouldQueue
{
    public function __invoke(OverdraftLimitReached $event)
    {
        $user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->first();

        $user = $account->user;
		
		Mail::to($user->email)->send(new LoanProposalMail());
    }
}
