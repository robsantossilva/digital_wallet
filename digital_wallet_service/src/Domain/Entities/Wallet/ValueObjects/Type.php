<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class Type extends ValueObjectAbstract
{

    const USER = 'USER';
    const SHOPKEEPER = 'SHOPKEEPER';

    protected $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function isValid()
    {
        if ($this->value !== self::USER && $this->value !== self::SHOPKEEPER) {
            $this->setErrorMessage("Invalid Type");
            return false;
        }

        return true;
    }

    public function getValue()
    {
        return $this->value;
    }
}
