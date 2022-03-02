<?php

namespace Robsantossilva\Tests\Unit\Domain\Entities\Wallet\ValueObjects;

use PHPUnit\Framework\TestCase;
use Robsantossilva\Tests\Traits\TestValueObject;
use Ramsey\Uuid\Uuid;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\Id;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\Name;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\DocumentNumber;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\Email;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\Password;

class ValueObjectsTest extends TestCase
{
    use TestValueObject;

    /**
     * @dataProvider additionProvider
     */
    public function testValueObject($class, $constructorValue, $isValidReturn, $errorMessageExpected)
    {

        $obj = new $class($constructorValue);

        $this->assertImplementsValueObjectInterface($obj);

        $this->assertEquals($obj->isValid(), $isValidReturn);

        if ($class === Id::class && $isValidReturn == true) {
            $this->assertTrue(Uuid::isValid($obj->getValue()));
        } else if ($class === Id::class && $isValidReturn == false) {
            $this->assertEquals($constructorValue, $obj->getValue());
        } else if ($class === Password::class && $isValidReturn == true && $constructorValue == 'Qw@123') {
            $this->assertTrue(password_verify($constructorValue, $obj->getValue()));
        } else if ($class === Password::class && $isValidReturn == true && $constructorValue == '$2y$15$2Y7LfUJ4tu.kAwYkFA5sHe.hOqjtwdvcmd.zKDh3DIqhpncxnguqW') {
            $this->assertTrue(password_verify('Qw@123', $obj->getValue()));
        } else {
            $this->assertEquals($constructorValue, $obj->getValue());
        }

        $this->assertEquals($errorMessageExpected, $obj->getErrorMessage());
    }

    public function additionProvider(): array
    {
        return [
            [Id::class, '', true, ''],
            [Id::class, '123qwe456rty', false, 'Invalid Id'],
            [Id::class, '9f7437fd-7091-4f09-87cb-4c5c2fa986a9', true, ''],
            [Name::class, 'Robson Silva', true, ''],
            [Name::class, 'Rob123', false, 'Invalid Name'],
            [DocumentNumber::class, '58843993089', true, ''],
            [DocumentNumber::class, '79431226000105', true, ''],
            [DocumentNumber::class, '32145709812', false, 'Invalid CPF or CNPJ'],
            [DocumentNumber::class, '10104575000192', false, 'Invalid CPF or CNPJ'],
            [Email::class, 'robson@gmail.com', true, ''],
            [Email::class, 'robson@', false, 'Invalid email'],
            [Password::class, '', false, 'Password cannot be empty'],
            [Password::class, 'Qw@12', false, 'Password cannot be less than 6'],
            [Password::class, 'Qwe@zx', false, 'Password must contain at least one number'],
            [Password::class, 'qw@123', false, 'Password must contain at least one upper case letter'],
            [Password::class, 'QW@123', false, 'Password must contain at least one lower case letter'],
            [Password::class, 'QwA123', false, 'Password must contain at least one special character'],
            [Password::class, 'XXXXXXXL4XmZo.HZO8sehig7bv5yev5Oxfd2YCHmA8tBP3PRaCPmYBLGDyUu', false, 'Invalid hash password'],
            [Password::class, 'Qw@123', true, ''],
            [Password::class, '$2y$15$2Y7LfUJ4tu.kAwYkFA5sHe.hOqjtwdvcmd.zKDh3DIqhpncxnguqW', true, '']
        ];
    }

    public function testPasswordVerify()
    {
        $validPassword = 'Qw@123';
        $obj = new Password($validPassword);
        $this->assertTrue($obj->PasswordVerify('Qw@123'));

        $validPasswordHash = '$2y$15$2Y7LfUJ4tu.kAwYkFA5sHe.hOqjtwdvcmd.zKDh3DIqhpncxnguqW'; //Qw@123
        $obj = new Password($validPasswordHash);
        $this->assertTrue($obj->PasswordVerify('Qw@123'));
    }

    /**
     * @dataProvider docNumberProvider
     */
    public function testDocumentNumber($value, $methodName, $assert)
    {
        $documentNumber = new DocumentNumber($value);
        $documentNumberRC = new \ReflectionClass(DocumentNumber::class);

        $method = $documentNumberRC->getMethod($methodName);
        $method->setAccessible(true);
        $this->assertEquals($assert, $method->invokeArgs($documentNumber, []));
    }

    public function docNumberProvider()
    {
        return [
            ['58843993089', 'validCPF', true],
            ['32145709812', 'validCPF', false],
            ['79431226000105', 'validCNPJ', true],
            ['10104575000192', 'validCNPJ', false],
            ['99999999999999', 'validCNPJ', false],
        ];
    }
}
