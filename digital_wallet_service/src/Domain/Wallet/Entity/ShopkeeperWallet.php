<?php

namespace Robsantossilva\DigitalWallet\Domain\Wallet\Entity;

class ShopkeeperWallet extends Wallet
{

    public function __construct(
        string $id,
        string $name,
        string $documentNumber,
        string $email,
        string $password,
        float $balance
    ) {
        parent::__construct(
            $id,
            $name,
            $documentNumber,
            $email,
            $password,
            $balance,
            self::SHOPKEEPER
        );
    }

    public function validTypesToTransfer(): array
    {
        return [];
    }
}
