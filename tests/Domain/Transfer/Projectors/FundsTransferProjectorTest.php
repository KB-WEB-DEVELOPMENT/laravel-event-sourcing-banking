<?php

namespace Tests\Domain\Transfer\Projectors;

use Illuminate\Support\Facades\Auth;

use App\Domain\Transfer\Exceptions\AmountZeroException;
use App\Domain\Transfer\Exceptions\AmountNegativeException;
use App\Domain\Transfer\Exceptions\InsufficientFundsException;
use App\Domain\Transfer\Exceptions\CouldNotFindCreditorAccountException;
use App\Domain\Transfer\Exceptions\SameAccountsException;

use App\Domain\Transfer\TransferFundsAggregateRoot;
use App\Models\Account;
use App\Models\TransferFund;
use Tests\TestCase;

class FundsTransferProjectorTest extends TestCase
{
    public function test_transfer_zero_amount(): void
    {
       $this->expectException(AmountZeroException::class);
	   
	   $amount = round(0,2);
	   
	   $transferFundsAggRootObj = new TransferFundsAggregateRoot(); 
	   
	   $transferFundsAggRootObj->checkTransferAmount($amount);
	}

    public function test_transfer_negative_amount(): void
    {
       $this->expectException(AmountNegativeException::class);
	   
	   $amount = -5.24;
	   
	   $transferFundsAggRootObj = new TransferFundsAggregateRoot();
	   
	   $transferFundsAggRootObj->checkTransferAmount($amount);
    }

    public function test_transfer_valid_amount(): void
    {
       $amount = 100.12;

	   $transferFundsAggRootObj = new TransferFundsAggregateRoot();	

	   $boolean = $transferFundsAggRootObj->checkTransferAmount($amount);
	   
	   $this->assertTrue($boolean);
    }

    public function test_insufficient_amount(): void
    {
       $this->expectException(InsufficientFundsException::class);
	   
	   $amount = 199999999999999.26;
	   
	   $transferFundsAggRootObj = new TransferFundsAggregateRoot();
	   
	   $transferFundsAggRootObj->checkSufficientFunds($amount);
    }

	public function test_sufficient_amount(): void
    {
       $amount = 1.01;

	   $transferFundsAggRootObj = new TransferFundsAggregateRoot();

	   $boolean = $transferFundsAggRootObj->checkSufficientFunds($amount);
	   
	   $this->assertTrue($boolean);
    }

	public function test_unknown_creditor(): void
    {
       $this->expectException(CouldNotFindCreditorAccountException::class);

	   $transferFundsAggRootObj = new TransferFundsAggregateRoot();	

	   $transferFundsAggRootObj->checkCreditor('some-non-existing-uuid-string');
	  
    }	

	public function test_valid_creditor(): void
    {
        $transferFundsAggRootObj = new TransferFundsAggregateRoot();
		
		boolean = $transferFundsAggRootObj->checkCreditor('9897a490-2cfd-4943-86ce-d287bf04342f');
		
		$this->assertTrue($boolean);
    }
   
	public function test_same_debitor_creditor(): void
    {
        $this->expectException(SameAccountsException::class);
    		
        $transferFundsAggRootObj = new TransferFundsAggregateRoot();		
		
	    $transferFundsAggRootObj->checkDebitorOtherAsCreditor('1af219db-6593-4993-8b9d-29a1c00c85b3');	
	}

	public function test_different_debitor_creditor(): void
    {
       $transferFundsAggRootObj = new TransferFundsAggregateRoot();
	   
	   boolean = $transferFundsAggRootObj->checkDebitorOtherAsCreditor('9897a490-2cfd-4943-86ce-d287bf04342f');
    
	   $this->assertTrue($boolean);	
	} 	

	public function test_valid_transfer(): void
    {
		$amount = 8.99;
        
		$creditor_account_uuid = '9897a490-2cfd-4943-86ce-d287bf04342f';
		
		$transferFundsAggRootObj = new TransferFundsAggregateRoot();
		
		$result = $transferFundsAggRootObj->transferFunds($amount,$creditor_account_uuid);
    
		$this->assertInstanceOf(TransferFundsAggregateRoot::class,$result);
	}     
}
