<?php

namespace App\Domain\Account\Projectors;

use Illuminate\Support\Facades\Auth;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

use App\Domain\Account\Events\AccountOpened;
use App\Domain\Account\Events\FundsDeposited;
use App\Domain\Account\Events\FundsWithdrawn;
use App\Domain\Account\Events\OverdraftLimitChanged;
use App\Domain\Account\Events\AccountClosed;

use App\Models\User;
use App\Models\Account;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class AccountProjector extends Projector
{
    public function onAccountOpened(AccountOpened $event):void
    {
		$account_uuid = Uuid::uuid4();
		$user_id = Auth::id();
		
		Account::create([
            'account_uuid' => $account_uuid->toString(),
			'balance' => 0.00,
			'overdraft' => 0,
            'user_id' => $user_id
        ]);
    }

    public function onFundsDeposited(FundsDeposited $event):void
    {
        $user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->first();

        $account->balance += round($event->amount,2);

        $account->save();
    }

    public function onFundsWithdrawn(FundsWithdrawn $event):void
    {
        $user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->first();

        $account->balance -= round($event->amount,2);

        $account->save();
    }

    public function onOverdraftLimitChanged(OverdraftLimitChanged $event):void
    {
        $user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->first();
		
		$account->overdraft = $event->amount;
    
		$account->save();
	}
	
	public function onAccountClosed(AccountClosed $event):void
    {
        $user_id = Auth::id();

        $account = Account::where('user_id',$user_id)->first();

        $account->balance = 0.00;

        $account->save(); 

		$account->delete();
    }
}
