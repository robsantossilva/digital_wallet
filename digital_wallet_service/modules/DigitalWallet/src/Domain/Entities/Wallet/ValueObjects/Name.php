<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class Name extends ValueObjectAbstract
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;
    }

    public function isValid()
    {
        if (!preg_match("/^([a-zA-Z' ]+)$/", $this->value)) {
            $this->setErrorMessage('Invalid Name');
            return false;
        }
        return true;
    }

    public function getValue()
    {
        return $this->value;
    }
}
