<?php

namespace Robsantossilva\DigitalWallet\Domain\Entities\Wallet\ValueObjects;

use Robsantossilva\DigitalWallet\Domain\Entities\ValueObjectAbstract;

class Password extends ValueObjectAbstract
{
    protected $value;
    protected $originalValue;
    private $statusPassword;

    public function __construct($value = '')
    {
        $this->originalValue = $value;
        $this->statusPassword = 'DECRIPTED_PASSWORD';
        if (strlen($value) >= 60) {
            $this->statusPassword = 'ENCRIPTED_PASSWORD';
            $this->value = $value;
        } else {
            $this->value = $this->PasswordHash($value);
        }
    }

    public function isValid()
    {
        if ($this->statusPassword == 'DECRIPTED_PASSWORD') {
            $number = preg_match('@[0-9]@', $this->originalValue);
            $uppercase = preg_match('@[A-Z]@', $this->originalValue);
            $lowercase = preg_match('@[a-z]@', $this->originalValue);
            $specialChars = preg_match('@[^\w]@', $this->originalValue);

            if ($this->originalValue == '') {
                $this->setErrorMessage("Password cannot be empty");
                return false;
            } else if (strlen($this->originalValue) < 6) {
                $this->setErrorMessage("Password cannot be less than 6");
                return false;
            } else if (!$number) {
                $this->setErrorMessage("Password must contain at least one number");
                return false;
            } else if (!$uppercase) {
                $this->setErrorMessage("Password must contain at least one upper case letter");
                return false;
            } else if (!$lowercase) {
                $this->setErrorMessage("Password must contain at least one lower case letter");
                return false;
            } else if (!$specialChars) {
                $this->setErrorMessage("Password must contain at least one special character");
                return false;
            }
        } else {
            $info = password_get_info($this->value);
            if ($info['algoName'] !== 'bcrypt') {
                $this->setErrorMessage("Invalid hash password");
                return false;
            }
        }

        return true;
    }

    public function getValue()
    {
        if ($this->getErrorMessage() !== '') {
            return $this->originalValue;
        }
        return $this->value;
    }

    public function passwordHash($value)
    {
        return password_hash($value, PASSWORD_DEFAULT, [
            'cost' => 15
        ]);
    }

    public function passwordVerify($value)
    {
        return password_verify($value, $this->value);
    }
}
