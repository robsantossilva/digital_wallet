<?php

namespace Robsantossilva\Tests\Unit\Domain\Entities\Wallet;

use PHPUnit\Framework\TestCase;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ShopkeeperWallet;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\Wallet;
use Robsantossilva\Tests\Stubs\ValueObjectStub;

class ShopkeeperWalletTest extends TestCase
{
    public function testNewShopkeeperWallet()
    {
        $inputValues = [
            '9f7437fd-7091-4f09-87cb-4c5c2fa986a9',
            'Robson Silva',
            '39514395808',
            'robsantossilva@gmail.com',
            '$2y$15$2Y7LfUJ4tu.kAwYkFA5sHe.hOqjtwdvcmd.zKDh3DIqhpncxnguqW',
            0
        ];

        $id = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[0]);
        $name = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[1]);
        $documentNumber = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[2]);
        $email = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[3]);
        $password = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[4]);
        $balance = (new ValueObjectStub())->setReturnForMethodIsValid(true)->setReturnForMethodGetValue($inputValues[5]);

        $shopkeeperWallet = new ShopkeeperWallet(
            $id,
            $name,
            $documentNumber,
            $email,
            $password,
            $balance
        );

        $this->assertInstanceOf(Wallet::class, $shopkeeperWallet);
        $this->assertEquals([], $shopkeeperWallet->validTypesToTransfer());
    }
}
