<?php

namespace Robsantossilva\DigitalWallet\Domain\Wallet\Entity\Traits;

use Robsantossilva\DigitalWallet\Domain\Exceptions\DomainException;

trait Password
{

    public function validatePassword($value)
    {

        if ($value == '') {
            throw new DomainException("Password cannot be empty", 1);
        }

        // if (strlen($value) >= 60) {
        //     $info = password_get_info($value);
        //     if ($info['algoName'] !== 'bcrypt') {
        //         throw new DomainException("Invalid hash password", 1);
        //     }
        // } else {

        $number = preg_match('@[0-9]@', $value);
        $uppercase = preg_match('@[A-Z]@', $value);
        $lowercase = preg_match('@[a-z]@', $value);
        $specialChars = preg_match('@[^\w]@', $value);

        if (strlen($value) < 6) {
            throw new DomainException("Password cannot be less than 6");
        } else if (!$number) {
            throw new DomainException("Password must contain at least one number");
        } else if (!$uppercase) {
            throw new DomainException("Password must contain at least one upper case letter");
        } else if (!$lowercase) {
            throw new DomainException("Password must contain at least one lower case letter");
        } else if (!$specialChars) {
            throw new DomainException("Password must contain at least one special character");
        }
        //$value = $this->passwordHash($value);
        //}

        return $value;
    }

    // private function passwordHash($value)
    // {
    //     return password_hash($value, PASSWORD_DEFAULT, [
    //         'cost' => 15
    //     ]);
    // }

    // public function passwordVerify($password, $hashPassword)
    // {
    //     return password_verify($password, $hashPassword);
    // }
}
