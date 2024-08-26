<?php
namespace App\Domain\Account\Exceptions;

use DomainException;

class CouldNotCloseAccountException extends DomainException
{
	public static function printNonEmptyMessage(): self
    {
        return new static("Could not close the account because its balance is not empty.");
    }
}
