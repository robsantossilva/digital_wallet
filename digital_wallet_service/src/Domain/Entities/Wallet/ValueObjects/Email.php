<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class Email extends ValueObjectAbstract
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;
    }

    public function isValid()
    {
        if (!filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage("Invalid email");
            return false;
        }
        return true;
    }

    public function getValue()
    {
        return $this->value;
    }
}
