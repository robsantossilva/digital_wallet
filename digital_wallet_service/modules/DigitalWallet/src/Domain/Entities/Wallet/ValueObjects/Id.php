<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;
use Ramsey\Uuid\Uuid;

class Id extends ValueObjectAbstract
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;

        if ($value == '') {
            $this->value = Uuid::uuid4();
        }
    }

    public function isValid()
    {
        if (!Uuid::isValid($this->getValue())) {
            $this->setErrorMessage("Invalid Id");
            return false;
        }
        return true;
    }

    public function getValue()
    {
        return $this->value;
    }
}
