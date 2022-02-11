<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects;

use Exception;
use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectInterface;
use Ramsey\Uuid\Uuid;

class Id implements ValueObjectInterface
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = $value;

        if ($value == '') {
            $this->value = Uuid::uuid4();
        }
    }

    public function IsValid()
    {
        if ($this->value == '') {
            throw new Exception("Id cannot be empty");
        }
        return Uuid::isValid($this->GetValue());
    }

    public function GetValue()
    {
        return $this->value;
    }
}
