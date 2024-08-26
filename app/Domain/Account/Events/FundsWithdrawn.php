<?php
namespace App\Domain\Account\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class FundsWithdrawn extends ShouldBeStored
{
    public function __construct(
		public float $amount 
    ){}
}