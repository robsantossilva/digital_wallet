<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities;

use Robsantossilva\DigitalWallet\Domain\Events\DomainEvents;

abstract class EntityAbstract
{
    use DomainEvents;

    abstract protected function validate();

    abstract public function getValues();
}
