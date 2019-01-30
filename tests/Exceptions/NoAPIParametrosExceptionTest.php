<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 16:25
 */
declare(strict_types=1);

namespace App\Tests\Exceptions;

use App\Exceptions\NoAPIParametrosException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class NoAPIParametrosExceptionTest
 */
class NoAPIParametrosExceptionTest extends WebTestCase
{
    /**
     * @dataProvider providerAPIUrls
     */
    public function testNoParametersException($url)
    {
        $this->expectException(NoAPIParametrosException::class);
        $this->expectExceptionMessage('No me has enviado ningun parametro');

        $client = static::createClient();
        $client->request('POST', $url);

        if (empty($client->getRequest()->request->count())) {
            throw new NoAPIParametrosException();
        }
    }

    public function providerAPIUrls()
    {
        yield ['/api/tienda/add'];
        yield ['/api/producto/add'];
        yield ['/api/shopper/add'];
        yield ['/api/pedido/add'];
    }
}