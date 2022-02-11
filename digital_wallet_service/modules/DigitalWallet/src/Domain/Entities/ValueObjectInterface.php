<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities;

interface ValueObjectInterface
{
    public function IsValid();
    public function GetValue();
}
