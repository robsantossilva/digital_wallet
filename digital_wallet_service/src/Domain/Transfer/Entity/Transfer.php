<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Transfer;

use Robsantossilva\DigitalWallet\Domain\Entities\EntityAbstract;
use Robsantossilva\DigitalWallet\Domain\Entities\Wallet\Wallet;
use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;

class Transfer extends EntityAbstract
{

    protected $from;
    protected $to;
    protected $value;

    public function __construct(
        Wallet $from,
        Wallet $to,
        float $value
    ) {
        $this->from = $from;
        $this->to = $to;
        $this->value = $value;
    }

    protected function validate()
    {
        //Valid transfer
        if (!$this->isValidTransfer()) {
            throw new DomainException("Cannot transfer from " . ($this->from->getWalletType()) . " to " . ($this->to->getWalletType()), 1);
        }

        if (!$this->isBalanceAvailable()) {
            throw new DomainException("Balance not available from" . ($this->from->getWalletType()) . " to " . ($this->to->getWalletType()), 1);
        }

        return true;
    }

    public function completeTransfer()
    {
    }

    public function getValues()
    {
        return [
            'from' => $this->from->getValues(),
            'to' => $this->to->getValues(),
            'value' => $this->valor
        ];
    }

    protected function isValidTransfer()
    {
        return in_array($this->to->getWalletType(), $this->from->validTypesToTransfer());
    }

    protected function isBalanceAvailable()
    {
        return ($this->from->getBalance() >= $this->value);
    }
}
