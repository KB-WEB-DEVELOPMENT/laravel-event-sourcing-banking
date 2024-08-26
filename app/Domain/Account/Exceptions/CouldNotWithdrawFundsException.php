<?php
namespace App\Domain\Account\Exceptions;

use DomainException;

class CouldNotWithdrawFundsException extends DomainException
{    
	public static function insufficientFunds(float $overdrawn_amount): self
    {     
		return new static("Could not withdraw funds because your account is {$overdrawn_amount} overdrawn");
    }
	
	public static function withdrawalAmountEqualsZero(float $amount): self
    {
        return new static("Could not withdraw funds because the withdrawal amount {$amount} is zero.");
    }

    public static function withdrawalAmountNegative(float $amount): self
    {
        return new static("Could not withdraw funds because the withdrawal amount {$amount} is negative.");
    }
	
	public static function overdraftReached(): self
    {
        return new static("Could not withdraw funds because your overdraft has been reached.");
    }	
}