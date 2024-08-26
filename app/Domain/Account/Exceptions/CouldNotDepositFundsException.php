<?php
namespace App\Domain\Account\Exceptions;

use DomainException;

class CouldNotDepositFundsException extends DomainException
{	
	public static function printZeroDepositMessage(): self
    {
        return new static("Could not deposit funds because the amount deposited is zero.");
    }

    public static function printNegativeDepositMessage(): self
    {
        return new static("Could not deposit funds because the amount deposited is a negative value.");
    }

}
