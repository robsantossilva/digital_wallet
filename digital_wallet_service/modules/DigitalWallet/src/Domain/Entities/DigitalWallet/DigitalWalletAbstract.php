<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet;

use Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects\DocumentNumber;
use Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects\Id;
use Robsantossilva\DigitalWallet\Domain\Entities\DigitalWallet\ValueObjects\Name;

abstract class DigitalWalletAbstract
{
    protected $id;
    protected $name;
    protected $documentNumber;
    protected $email;
    protected $password;
    protected $balance;

    public function __construct(
        Id $id,
        Name $name,
        DocumentNumber $documentNumber,
        string $email,
        string $password,
        float $balance
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->documentNumber = $documentNumber;
        $this->email = $email;
        $this->password = $password;
        $this->balance = $balance;
    }
}
