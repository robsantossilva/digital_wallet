<?php

namespace Robsantossilva\Tests\Unit\Domain\Entities\Wallet;

use PHPUnit\Framework\TestCase;
use Robsantossilva\DigitalWallet\Domain\Entities\EntityAbstract;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects\Type;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\Wallet;
use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;
use Robsantossilva\Tests\Stubs\ValueObjectStub;

class WalletTest extends TestCase
{
    public function testNewWallet()
    {

        $inputValues = [
            '9f7437fd-7091-4f09-87cb-4c5c2fa986a9',
            'Robson Silva',
            '39514395808',
            'robsantossilva@gmail.com',
            '$2y$15$2Y7LfUJ4tu.kAwYkFA5sHe.hOqjtwdvcmd.zKDh3DIqhpncxnguqW',
            0,
            Type::USER
        ];

        $id = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[0]);
        $name = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[1]);
        $documentNumber = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[2]);
        $email = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[3]);
        $password = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[4]);
        $balance = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[5]);
        $type = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[6]);

        $wallet = new Wallet($id, $name, $documentNumber, $email, $password, $balance, $type);

        $this->assertInstanceOf(EntityAbstract::class, $wallet);

        $this->assertEqualsCanonicalizing($inputValues, $wallet->getValues());

        $validate = self::getMethod('validate');
        $this->assertTrue($validate->invokeArgs($wallet, []));
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

        $basePayload = [
            /*Id*/
            (new ValueObjectStub())->setReturnForMethodIsValid(true),
            /*Name*/ (new ValueObjectStub())->setReturnForMethodIsValid(true),
            /*documentNumber*/ (new ValueObjectStub())->setReturnForMethodIsValid(true),
            /*Email*/ (new ValueObjectStub())->setReturnForMethodIsValid(true),
            /*Password*/ (new ValueObjectStub())->setReturnForMethodIsValid(true),
            /*Balance*/ (new ValueObjectStub())->setReturnForMethodIsValid(true),
            /*Type*/ (new ValueObjectStub())->setReturnForMethodIsValid(true),
            ''
        ];

        $case1 = $basePayload;
        $case1[0] = (new ValueObjectStub())->setReturnForMethodIsValid(false)->setReturnForMethodGetErrorMessage('Invalid Id');
        $case1[7] = 'Invalid Id';

        $case2 = $basePayload;
        $case2[1] = (new ValueObjectStub())->setReturnForMethodIsValid(false)->setReturnForMethodGetErrorMessage('Invalid Name');
        $case2[7] = 'Invalid Name';

        $case3 = $basePayload;
        $case3[2] = (new ValueObjectStub())->setReturnForMethodIsValid(false)->setReturnForMethodGetErrorMessage('Invalid DocumentNumber');
        $case3[7] = 'Invalid DocumentNumber';

        $case4 = $basePayload;
        $case4[3] = (new ValueObjectStub())->setReturnForMethodIsValid(false)->setReturnForMethodGetErrorMessage('Invalid Email');
        $case4[7] = 'Invalid Email';

        $case5 = $basePayload;
        $case5[4] = (new ValueObjectStub())->setReturnForMethodIsValid(false)->setReturnForMethodGetErrorMessage('Invalid Password');
        $case5[7] = 'Invalid Password';

        $case6 = $basePayload;
        $case6[6] = (new ValueObjectStub())->setReturnForMethodIsValid(false)->setReturnForMethodGetErrorMessage('Invalid Type');
        $case6[7] = 'Invalid Type';

        return [
            $case1,
            $case2,
            $case3,
            $case4,
            $case5,
            $case6
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
