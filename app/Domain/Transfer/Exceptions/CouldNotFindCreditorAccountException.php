<?php
namespace App\Domain\Transfer\Exceptions;

use DomainException;

class CouldNotFindCreditorAccountException extends DomainException
{
	public static function printMessage(string $creditor_account_uuid): self
    {
        return new static("Bank account No. {$creditor_account_uuid} cannot be found in our database.");
    }	
}	