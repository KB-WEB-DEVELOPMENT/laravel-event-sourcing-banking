<?php
namespace App\Domain\Transfer\Exceptions;

use DomainException;

class AmountNegativeException extends DomainException
{
    public static function printMessage(): self
    {
        return new static('You cannot transfer a negative amount of money.');
    }
}
