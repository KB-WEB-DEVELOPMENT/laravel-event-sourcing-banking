<?php
namespace App\Domain\Transfer\Exceptions;

use DomainException;

class AmountZeroException extends DomainException
{
    public static function printMessage(): self
    {
        return new static('You cannot transfer an amount of money worth zero or null.');
    }	
}