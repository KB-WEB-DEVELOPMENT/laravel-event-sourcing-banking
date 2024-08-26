<?php
namespace App\Domain\Transfer\Exceptions;

use DomainException;

class InsufficientFundsException extends DomainException
{
    public static function printMessage(float $amount,float $balance,int $overdraft): self
    {
        $missing_funds = abs(round($balance,2) + round((float)$overdraft,2) - round($amount,2));
		
		return new static("There is insufficient funds, {$missing_funds} is missing on your bank account to carry out the bank transfer");
    }	
}
