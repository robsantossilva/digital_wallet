<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class DocumentNumber extends ValueObjectAbstract
{
    protected $value;

    public function __construct($value = '')
    {
        $this->value = preg_replace('/[^0-9]/', '', $value);
    }

    public function isValid()
    {
        if ($this->validCPF()) {
            return true;
        }

        if ($this->validCNPJ()) {
            return true;
        }

        $this->setErrorMessage('Invalid CPF or CNPJ');

        return false;
    }

    public function getValue()
    {
        return $this->value;
    }

    protected function validCPF()
    {
        if (strlen($this->value) !== 11 || preg_match('/(\d)\1{10}/', $this->value)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->value[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($this->value[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    protected function validCNPJ()
    {
        $cnpj = $this->value;

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
}
