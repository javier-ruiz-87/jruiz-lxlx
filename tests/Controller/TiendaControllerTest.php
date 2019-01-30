<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 11:43
 */

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Tests\Utils\GenerateRandoms;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\Tienda;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TiendaControllerTest
 */
class TiendaControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerUrls
     */
    public function testIndex($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode(),
            sprintf('The %s public URL loads correctly.', $url)
        );
    }

    public function providerUrls()
    {
        yield ['/tienda/'];
        yield ['/tienda/new'];
        yield ['/tienda/1/edit'];
        yield ['/tienda/1'];
    }

    public function testNewTienda()
    {
        $generateRandoms = new GenerateRandoms();
        $tiendaNombre = 'Mi hipermercadona '.mt_rand();
        $tiendaDireccion = $generateRandoms->generateRandomString(255);

        $client = static::createClient();
        $crawler = $client->request('GET', 'http://localhost:8000/tienda/new');

        $form = $crawler->selectButton('Save')->form([
           'tienda[nombre]' => $tiendaNombre,
           'tienda[direccion]' => $tiendaDireccion
        ]);
        $client->submit($form);

        $this->assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        /** @var Tienda $tienda */
        $tienda = $client->getContainer()->get('doctrine')->getRepository(Tienda::class)->findOneBy([
            'nombre' => $tiendaNombre,
        ]);

        $this->assertNotNull($tienda);
        $this->assertSame($tiendaDireccion, $tienda->getDireccion());
    }
}