<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 11:08
 */
declare(strict_types=1);

namespace App\Exceptions;

use Throwable;

/**
 * Class ValorIncorrectoException
 */
class ValorIncorrectoException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Valor incorrecto: ".$message, $code, $previous);
    }
}
{

}