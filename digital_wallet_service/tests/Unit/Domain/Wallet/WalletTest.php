<?php

namespace Robsantossilva\Tests\Unit\Domain\Entities\Wallet;

use PHPUnit\Framework\TestCase;
use Robsantossilva\DigitalWallet\Domain\Entities\EntityAbstract;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\Type;
use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;
use Robsantossilva\Tests\Stubs\ValueObjectStub;
use Robsantossilva\Tests\Stubs\WalletStub as Wallet;

class WalletTest extends TestCase
{
    public function testNewWallet()
    {

        $inputValues = [
            '9f7437fd-7091-4f09-87cb-4c5c2fa986a9',
            'Robson Silva',
            '39514395808',
            'robsantossilva@gmail.com',
            'A@derf34',
            0,
            Wallet::USER
        ];

        $id = $inputValues[0];
        $name = $inputValues[1];
        $documentNumber = $inputValues[2];
        $email = $inputValues[3];
        $password = $inputValues[4];
        $balance = $inputValues[5];
        $type = $inputValues[6];

        $newWallet = new Wallet($id, $name, $documentNumber, $email, $password, $balance, $type);

        $this->assertInstanceOf(EntityAbstract::class, $newWallet);

        $this->assertEqualsCanonicalizing($inputValues, $newWallet->getValues());

        $validate = self::getMethod('validate');
        $this->assertTrue($validate->invokeArgs($newWallet, []));
        $this->assertEquals(Wallet::USER, $newWallet->getWalletType());
    }

    /**
     * @dataProvider constructPayload
     */
    public function testExceptions($id, $name, $documentNumber, $email, $password, $balance, $type, $expectedErrorMessage)
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage($expectedErrorMessage);

        new Wallet($id, $name, $documentNumber, $email, $password, $balance, $type);
    }

    public function constructPayload()
    {
        $baseParams = [
            /*Id*/
            "id" => "9f7437fd-7091-4f09-87cb-4c5c2fa986a9",
            /*Name*/ "name" => "Robson dos Santos",
            /*documentNumber*/ "documentNumber" => "12345678909",
            /*Email*/ "email" => "robsantossilva@gmail.com",
            /*Password*/ "password" => "A@derf34",
            /*Balance*/ "balance" => 0,
            /*Type*/ "type" => Wallet::USER,
            "expectedErrorMessage" => ''
        ];

        return [
            array_merge($baseParams, ["id" => "123", "expectedErrorMessage" => 'Invalid id']),
            array_merge($baseParams, ["name" => "", "expectedErrorMessage" => 'Invalid name']),
            array_merge($baseParams, ["documentNumber" => "12312312312", "expectedErrorMessage" => 'Invalid Document Number']),
            array_merge($baseParams, ["email" => "123@", "expectedErrorMessage" => 'Invalid email']),
            array_merge($baseParams, ["password" => "", "expectedErrorMessage" => 'Password cannot be empty']),
            array_merge($baseParams, ["type" => "type", "expectedErrorMessage" => 'Invalid type'])
        ];
    }

    protected static function getMethod($name)
    {
        $class = new \ReflectionClass(Wallet::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
