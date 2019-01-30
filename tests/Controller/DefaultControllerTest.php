<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 12:07
 */
declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultControllerTest
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerUrls
     */
    public function testIndex($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $response = $client->getResponse();

        $this->assertSame(
            Response::HTTP_OK,
            $response->getStatusCode()
//            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    public function providerUrls()
    {
        yield ['/'];
        yield ['/producto/'];
        yield ['/tienda/'];
        yield ["/shopper/"];
        yield ['http://localhost:8000/pedido/'];
    }
}