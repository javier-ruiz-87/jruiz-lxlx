<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 14:35
 */
declare(strict_types=1);

namespace App\Tests\Utils;

/**
 * Class GenerateRandoms
 */
class GenerateRandoms
{
    public function generateRandomString(int $length): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return mb_substr(str_shuffle(str_repeat($chars, (int)ceil($length / mb_strlen($chars)))), 1, $length);
    }
}