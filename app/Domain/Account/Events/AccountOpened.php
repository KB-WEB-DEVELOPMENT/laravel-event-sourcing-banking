<?php
namespace App\Domain\Account\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class AccountOpened extends ShouldBeStored
{
    public function __construct(
    ){}
}