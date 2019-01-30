<?php
/**
 * Created by PhpStorm.
 * User: Javier Ruiz
 * Date: 30/01/19
 * Time: 16:14
 */
declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Producto;
use App\Tests\Utils\GenerateRandoms;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class APIProductoControllerTest
 */
class APIProductoControllerTest extends WebTestCase
{
    public function providerUrls()
    {
        yield ['/api/producto/add'];
//        yield ['http://localhost:8000/api/tienda/add'];
    }

    /**
     * @dataProvider providerUrls
     */
    public function testAdd($url)
    {
        $generateRandoms = new GenerateRandoms();
        $productoNombre = 'Leche entera '.mt_rand();
        $productoPrecio = rand(100,500);
        $productoDescripcion = $generateRandoms->generateRandomString(255);

        $client = static::createClient();
        $client->request(
            'POST',
            $url,
            [
                'nombre' => $productoNombre,
                'descripcion' => $productoDescripcion,
                'unidades' => 10,
                'precio' => $productoPrecio,
                'tienda_id' => 1
            ]
        );

        /** @var Producto $producto */
        $producto = $client->getContainer()->get('doctrine')->getRepository(Producto::class)->findOneBy(
            [
                'nombre' => $productoNombre
            ]
        );

        $this->assertNotNull($producto);
        $this->assertSame($productoDescripcion, $producto->getDescripcion());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/json', $client->getResponse()->headers->get('Content-Type'));
    }

}