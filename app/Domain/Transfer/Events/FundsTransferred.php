<?php
namespace App\Domain\Transfer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class FundsTransferred extends ShouldBeStored
{
    public function __construct(
		public string $creditor_account_uuid,
		public float $amount
    ){}
}
