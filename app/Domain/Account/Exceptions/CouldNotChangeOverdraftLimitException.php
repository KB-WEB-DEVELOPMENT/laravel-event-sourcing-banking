<?php
namespace App\Domain\Account\Exceptions;

use DomainException;

class CouldNotChangeOverdraftLimitException extends DomainException
{
	public static function printZeroOverdraftMessage(): self
    {
        return new static("Could not set the overdraft to zero because it is its default value.");
    }

	public static function printNegativeOverdraftMessage(): self
    {
        return new static("Could not set the overdraft to a negative value.");
    }
}