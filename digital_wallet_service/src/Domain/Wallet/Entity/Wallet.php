<?php

namespace Robsantossilva\DigitalWallet\Domain\Wallet\Entity;

use Robsantossilva\DigitalWallet\Domain\Entities\EntityAbstract;
use Robsantossilva\DigitalWallet\Domain\Wallet\Entity\Traits\DocumentNumber;
use Robsantossilva\DigitalWallet\Domain\Wallet\Entity\Traits\Id;
use Robsantossilva\DigitalWallet\Domain\Wallet\Entity\Traits\Password;
use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;

abstract class Wallet extends EntityAbstract
{

    use Id, DocumentNumber, Password;

    const USER = 'USER';
    const SHOPKEEPER = 'SHOPKEEPER';

    protected $id;
    protected $name;
    protected $documentNumber;
    protected $email;
    protected $password;
    protected $balance;
    protected $type;

    public function __construct(
        string $id,
        string $name,
        string $documentNumber,
        string $email,
        string $password,
        float $balance,
        string $type
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->documentNumber = $documentNumber;
        $this->email = $email;
        $this->password = $password;
        $this->balance = $balance;
        $this->type = $type;

        $this->validate();
    }

    protected function validate()
    {
        $this->id = $this->ValidateID($this->id);

        if (!preg_match("/^([a-zA-Z' ]+)$/", $this->name)) {
            throw new DomainException("Invalid name", 1);
        }

        $this->ValidateDocumentNumber($this->documentNumber);

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException("Invalid email", 1);
        }

        $this->password = $this->validatePassword($this->password);

        if ($this->type !== self::USER && $this->type !== self::SHOPKEEPER) {
            throw new DomainException("Invalid type", 1);
        }
        return true;
    }

    public function getValues()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'documentNumber' => $this->documentNumber,
            'email' => $this->email,
            'password' => $this->password,
            'balance' => $this->balance,
            'type' => $this->type
        ];
    }

    public function getWalletType(): string
    {
        return $this->type;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    abstract public function validTypesToTransfer(): array;

    public function debitFromBalance(float $debitValor)
    {
        $balanceBeforeDebit = $this->balance;
        $this->balance -= $debitValor;

        // $this->notifyObservers('wallet:debitFromBalance', [
        //     $this,
        //     'balanceBeforeDebit' => $balanceBeforeDebit,
        //     'newBalance' => $this->balance,
        //     'valueDebited' => $valor
        // ]);
    }

    public function creditToBalance(float $creditValue)
    {
        $balanceBeforeCredit = $this->balance;
        $this->balance += $creditValue;
        // $this->notifyObservers('wallet:creditToBalance', [
        //     $this,
        //     'balanceBeforeCredit' => $balanceBeforeCredit,
        //     'newBalance' => $this->balance,
        //     'valueDebited' => $valor
        // ]);
        return $this;
    }
}
