<?php

use PHPUnit\Framework\TestCase;
use Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects\Id;
use Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects\Name;
use Robsantossilva\Tests\Traits\TestValueObject;
use Ramsey\Uuid\Uuid;
use Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects\DocumentNumber;

class IdTest extends TestCase
{
    use TestValueObject;

    /**
     * @dataProvider additionProvider
     */
    public function testValueObject($class, $initialValidValue, $validValue, $invalidValue)
    {

        // New Id
        $obj = new $class($initialValidValue);
        $this->assertImplementsValueObjectInterface($obj);
        $this->assertTrue($obj->IsValid());

        // New Value in construct
        $obj = new $class($validValue);
        $this->assertEquals($validValue, $obj->GetValue());

        // New Invalid value
        $obj = new $class($invalidValue);
        $this->assertFalse($obj->IsValid());
    }

    public function additionProvider(): array
    {
        return [
            [Id::class, '', Uuid::uuid4(), '123'],
            [Name::class, 'Robson Silva', 'Robson Silva', 'Rob123'],
            [DocumentNumber::class, '58843993089', '12345678909', '32145709812'],
            [DocumentNumber::class, '79431226000105', '86271857000161', '10104575000192']
        ];
    }
}
