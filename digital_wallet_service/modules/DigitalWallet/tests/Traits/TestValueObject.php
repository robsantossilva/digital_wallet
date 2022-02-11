<?php

namespace Robsantossilva\Tests\Traits;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectInterface;

trait TestValueObject
{
    public function assertImplementsValueObjectInterface($valueObject)
    {
        $reflection = new \ReflectionClass($valueObject);

        $this->assertTrue(
            in_array(
                ValueObjectInterface::class,
                $reflection->getInterfaceNames()
            )
        );
    }
}
