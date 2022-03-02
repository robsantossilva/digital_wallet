<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class Balance extends ValueObjectAbstract
{
    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isValid()
    {
        return true;
    }

    public function getValue()
    {
        return $this->value;
    }
}
