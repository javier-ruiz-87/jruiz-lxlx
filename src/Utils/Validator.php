<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 11:06
 */
declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\ValorIncorrectoException;

/**
 * Class Validator
 */
class Validator
{
    public function validateEmail(?string $email): string
    {
        if (empty($email)) {
            throw new ValorIncorrectoException('The email can not be empty.');
        }

        if (false === mb_strpos($email, '@')) {
            throw new ValorIncorrectoException('The email should look like a real email.');
        }

        return $email;
    }
}