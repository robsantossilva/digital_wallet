<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet;

use Robsantossilva\DigitalWallet\Domain\Entities\EntityAbstract;
use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;
use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;

class Wallet extends EntityAbstract
{

    protected $id;
    protected $name;
    protected $documentNumber;
    protected $email;
    protected $password;
    protected $balance;
    protected $type;

    public function __construct(
        ValueObjectAbstract $id,
        ValueObjectAbstract $name,
        ValueObjectAbstract $documentNumber,
        ValueObjectAbstract $email,
        ValueObjectAbstract $password,
        ValueObjectAbstract $balance,
        ValueObjectAbstract $type
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
        $fields = [
            $this->id,
            $this->name,
            $this->documentNumber,
            $this->email,
            $this->password,
            $this->balance,
            $this->type
        ];
        foreach ($fields as $i => $field) {
            $isValid = $field->isValid();
            //$fields[$i] = $isValid;
            if (!$isValid) {
                throw new DomainException($field->getErrorMessage(), 1);
            }
        }
        return true;
    }

    public function getValues()
    {
        return [
            'id' => $this->id->getValue(),
            'name' => $this->name->getValue(),
            'documentNumber' => $this->documentNumber->getValue(),
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
            'balance' => $this->balance->getValue(),
            'type' => $this->type->getValue()
        ];
    }

    // public function debitFromBalance($valor)
    // {
    //     $balanceBeforeDebit = $this->balance;
    //     $this->balance -= $valor;
    //     $this->notifyObservers('wallet:debitFromBalance', [
    //         $this,
    //         'balanceBeforeDebit' => $balanceBeforeDebit,
    //         'newBalance' => $this->balance,
    //         'valueDebited' => $valor
    //     ]);
    //     return $this->balance;
    // }

    // public function creditToBalance($valor)
    // {
    //     $balanceBeforeCredit = $this->balance;
    //     $this->balance += $valor;
    //     $this->notifyObservers('wallet:creditToBalance', [
    //         $this,
    //         'balanceBeforeCredit' => $balanceBeforeCredit,
    //         'newBalance' => $this->balance,
    //         'valueDebited' => $valor
    //     ]);
    //     return $this->balance;
    // }
}
