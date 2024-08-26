<?php
namespace App\Domain\Account\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AccountClosed extends ShouldBeStored
{
    public function __construct(
    ){}
}
