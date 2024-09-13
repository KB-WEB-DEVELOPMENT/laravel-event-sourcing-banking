<?php

namespace App\Domain\Transfer\Projectors;

use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Uuid;

use App\Models\User;
use App\Models\Account;
use App\Models\TransferFund;

use App\Domain\Transfer\Events\FundsTransferred;

use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class TransferFundsProjector extends Projector
{
    public function onFundsTransferred(FundsTransferred $event):void
    {
		$creditor_account_uuid = $event->creditor_account_uuid;

		$transferred_amount = round($event->amount,2);

		$user_id = Auth::id();
		
		$debitor_account = Account::where('user_id',$user_id)->first();

        $debitor_account_uuid = $debitor_account->account_uuid;
		
		$creditor_account = Account::where('account_uuid',$creditor_account_uuid)->first();

		$debitor_account->balance -= $transferred_amount;
				
		$creditor_account->balance += $transferred_amount;
				
		$debitor_account->save();
		
		$creditor_account->save();
				
		TransferFund::create([
            'debitor_account_uuid' => $debitor_account_uuid,
			'creditor_account_uuid' => $creditor_account_uuid,
			'amount' => $transferred_amount,
        ]);
	}
}
