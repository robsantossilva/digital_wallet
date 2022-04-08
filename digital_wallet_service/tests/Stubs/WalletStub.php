<?php

namespace Robsantossilva\Tests\Stubs;

use Robsantossilva\DigitalWallet\Domain\Wallet\Entity\Wallet;

class WalletStub extends Wallet
{
    public function validTypesToTransfer(): array
    {
        return [];
    }
}
