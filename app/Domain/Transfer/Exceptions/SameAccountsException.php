<?php
namespace App\Domain\Transfer\Exceptions;

use DomainException;

class SameAccountsException extends DomainException
{
    public static function printMessage(string $creditor_account_uuid): self
    {
        return new static('Error: The debitor account id and creditor account id are identical: {$creditor_account_uuid}');
    }	
}
