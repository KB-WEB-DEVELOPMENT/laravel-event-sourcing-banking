<?php
namespace App\Domain\Transfer\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class OverdraftLimitReached extends ShouldBeStored
{
    public function __construct(
    ){}
}