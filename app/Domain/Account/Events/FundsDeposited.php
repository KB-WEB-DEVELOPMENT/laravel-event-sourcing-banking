<?php
namespace App\Domain\Account\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class FundsDeposited extends ShouldBeStored
{
    public function __construct(
		public float $amount 
    ){}
}
