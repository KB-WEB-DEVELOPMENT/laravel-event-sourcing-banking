<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\TransferFund;

use App\Domain\Account\TransferFundsAggregateRoot;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class TransferFundsController extends Controller
{
	public function index(): View
    {
		$user = Auth::user();
		
		$account = Account::where('user_id',Auth::id())->firstOrFail();
        
		return view('transfers.create-transfer-form', compact('user','account'));
    }
	
    public function transfer(Request $request): View
    {			
		$amount = round($request->amount,2);
		
		$creditor_account_uuid = $request->creditor_account_uuid;
				 
		/* Note: I am not passing any params related to the logged in user to the transferFunds()
		   method. In this case, the logged in user is the debitor in the transaction.
		 */ 
		TransferFundsAggregateRoot->transferFunds($amount,$creditor_account_uuid)->persist();
	
		$this->index();
	}	
}
