<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities;

abstract class ValueObjectAbstract
{
    private $errorMessage = '';

    abstract public function isValid();

    abstract public function getValue();

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function setErrorMessage($message)
    {
        $this->errorMessage = $message;
    }
}
