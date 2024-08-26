<?php
namespace App\Domain\Account\Exceptions;

use DomainException;

class CannotCreateMultipleAccountsException extends DomainException
{
	public static function printMessage(): self
    {
        return new static("Error: A bank user can only have one bank account. You have already opened an account");
    }
}
