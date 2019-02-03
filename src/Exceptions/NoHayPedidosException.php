<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 2/02/19
 * Time: 13:53
 */

namespace App\Exceptions;

use Throwable;

/**
 * Class NoHayPedidosException
 */
class NoHayPedidosException extends \Exception
{
    public function __construct(string $message = "No hay pedidos aun para los valores enviados", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}