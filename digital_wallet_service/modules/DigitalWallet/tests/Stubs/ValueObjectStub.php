<?php

namespace Robsantossilva\Tests\Stubs;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class ValueObjectStub extends ValueObjectAbstract
{
    protected $returnForMethodIsValid;
    protected $returnForMethodGetValue;

    public function setReturnForMethodIsValid($returnValue)
    {
        $this->returnForMethodIsValid = $returnValue;
        return $this;
    }

    public function setReturnForMethodGetValue($returnValue)
    {
        $this->returnForMethodGetValue = $returnValue;
        return $this;
    }

    public function setReturnForMethodGetErrorMessage($message)
    {
        $this->setErrorMessage($message);
        return $this;
    }

    public function isValid()
    {
        return $this->returnForMethodIsValid;
    }

    public function getValue()
    {
        return $this->returnForMethodGetValue;
    }
}
