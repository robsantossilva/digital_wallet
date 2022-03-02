<?php

namespace Robsantossilva\DigitalWallet\Domain\Events;

use Robsantossilva\DigitalWallet\Domain\Entities\EntityAbstract;

interface ObserverInterface
{
    public function handle(EntityAbstract $entity, string $eventName, $data = null);
}
