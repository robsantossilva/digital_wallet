<?php

namespace Robsantossilva\Tests\Traits;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

trait TestValueObject
{
    public function assertImplementsValueObjectInterface($object)
    {
        // $reflection = new \ReflectionClass($object);

        // var_dump($reflection->getParentClass());

        $this->assertInstanceOf(ValueObjectAbstract::class, $object);
    }
}
