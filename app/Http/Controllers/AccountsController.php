<?php

namespace App\Http\Controllers;

use App\Domain\Account\Exceptions\CannotCreateMultipleAccountsException;

use App\Models\Account;

use App\Domain\Account\AccountAggregateRoot;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class AccountsController extends Controller
{
	public function index(): View
    {		
		$user = Auth::user();
		
		// Not really needed, the middleware takes care of this
		if (!$user) {
			return redirect('/login');
		}
		
		$account = Account::where('user_id',Auth::id())->firstOrFail();
        
		return view('accounts.index', compact('user','account'));
    }
	
    public function created(): View
    {
        $user_id = Auth::id();
		
		$account = Account::where('user_id',$user_id)->firstOrFail();
		
		if ($account) {
			throw CannotCreateMultipleAccountsException::printZeroDepositMessage();
		}
				
		// Note: I am not passing any logged in user related parameters to the openAccount() method 
		AccountAggregateRoot->openAccount()->persist();	

		$this->index();		
	}
	
	public function deposit(): View
    {
		$user = Auth::user();
		
		$account = Account::where('user_id',Auth::id())->firstOrFail();
        
		return view('accounts.deposit', compact('user','account'));
    }

    public function deposited(Request $request): View
    {
        $amount = round($request->amount,2);
				
		// Note: I am not passing any logged in user related parameters to the depositFunds() method
		AccountAggregateRoot->depositFunds($amount)->persist(); 
    
		$this->index();
	}
	
	public function withdraw(): View
    {
		$user = Auth::user();
		
		$account = Account::where('user_id',Auth::id())->firstOrFail();
        
		return view('accounts.withdraw', compact('user','account'));
    }

    public function withdrawn(Request $request): View
    {
        $amount = round($request->amount,2);
				
		// Note: I am not passing any logged in user related parameters to the withdrawFunds() method
		AccountAggregateRoot->withdrawFunds($amount)->persist(); 
		
		$this->index();
    }
		
	public function updateOverdraftLimit(): View
    {
		$user = Auth::user();
		
		$account = Account::where('user_id',Auth::id())->firstOrFail();
        
		return view('accounts.update', compact('user','account'));
    }
	
    public function updatedOverdraftLimit(Request $request): View
    {
		$new_overdraft = $request->overdraft;
				
		// Note: I am not passing any logged in user related parameters to the changeOverdraftLimit() method
		AccountAggregateRoot->changeOverdraftLimit($new_overdraft)->persist(); 
		
		$this->index();
    }

    public function closed(): View
    {		
		// Note: I am not passing any logged in user related parameters to the closeAccount() method
		AccountAggregateRoot->closeAccount()->persist(); 
		
		$this->index();
    }
	
}
