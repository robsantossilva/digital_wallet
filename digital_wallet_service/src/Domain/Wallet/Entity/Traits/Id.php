<?php

namespace Robsantossilva\DigitalWallet\Domain\Wallet\Entity\Traits;

use Ramsey\Uuid\Uuid;
use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;

trait Id
{

    public function validateID(string $value): string
    {
        if ($value == '') {
            $value = Uuid::uuid4()->toString();
        }

        if (!Uuid::isValid($value)) {
            throw new DomainException("Invalid id", 1);
        }
        return $value;
    }
}
