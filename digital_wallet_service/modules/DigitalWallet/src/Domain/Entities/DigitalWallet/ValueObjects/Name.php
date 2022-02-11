<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectInterface;

class Name implements ValueObjectInterface
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;
    }

    public function IsValid()
    {
        if (preg_match("/^([a-zA-Z' ]+)$/", $this->value)) {
            return true;
        }
        return false;
    }

    public function GetValue()
    {
        return $this->value;
    }
}
