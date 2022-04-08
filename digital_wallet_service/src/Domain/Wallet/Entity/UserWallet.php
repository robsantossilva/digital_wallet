<?php

namespace Robsantossilva\DigitalWallet\Domain\Wallet\Entity;

class UserWallet extends Wallet
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
            self::USER
        );
    }

    public function validTypesToTransfer(): array
    {
        return [
            self::SHOPKEEPER
        ];
    }
}
