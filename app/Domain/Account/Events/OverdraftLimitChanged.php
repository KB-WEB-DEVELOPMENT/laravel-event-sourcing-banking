<?php
namespace App\Domain\Account\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OverdraftLimitChanged extends ShouldBeStored
{
    public function __construct(
		public int $overdraft 
    ){}
}