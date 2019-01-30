<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 29/01/19
 * Time: 21:04
 */

namespace App\Exceptions;

use Throwable;

class NoAPIParametrosException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct('No me has enviado ningun parametro', $code, $previous);
    }
}