<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 14:31
 */
declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Tienda;
use App\Tests\Utils\GenerateRandoms;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class APITiendaControllerTest
 */
class APITiendaControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerUrls
     */
    public function testUrl($url)
    {
        $client = static::createClient();
        $client->request('POST', $url);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    public function providerUrls()
    {
        yield ['/api/tienda/add'];
//        yield ['http://localhost:8000/api/tienda/add'];
    }

    /**
     * @dataProvider providerUrls
     */
    public function testAdd($url)
    {
        $generateRandoms = new GenerateRandoms();
        $tiendaNombre = 'Mi hipermercadona '.mt_rand();
        $tiendaDireccion = $generateRandoms->generateRandomString(255);

        $client = static::createClient();
        $client->request(
            'POST',
            $url,
            [
                'nombre' => $tiendaNombre,
                'direccion' => $tiendaDireccion
            ]
        );

        /** @var Tienda $tienda */
        $tienda = $client->getContainer()->get('doctrine')->getRepository(Tienda::class)->findOneBy([
            'nombre' => $tiendaNombre,
        ]);

        $this->assertNotNull($tienda);
        $this->assertSame($tiendaDireccion, $tienda->getDireccion());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('Content-Type'));
    }
}